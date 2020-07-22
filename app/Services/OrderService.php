<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 8/25/2019
 * Time: 9:46 AM
 */

namespace App\Services;

use App\Classes\PaymentSystem;
use App\Coupon;
use App\Events\OrderActivated;
use App\Events\OrderCreated;
use App\Events\OrderUpdated;
use App\Exceptions\InvalidCouponException;
use App\Exceptions\OrderAlreadyActivatedException;
use App\Exceptions\OrderCanceledException;
use App\Exceptions\OrderNotPaidException;
use App\Order;
use App\Product;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class OrderService
{
    public function create($user, $data, Product $product)
    {
        /** @var PaymentSystem $paymentSystem */
        $paymentSystem = app(PaymentSystem::class);

        /** @var CouponService $couponService */
        $couponService = app(CouponService::class);

        $order = $this->createEmpty($user, $product->duration);

        $coupon = false;

        if ($data['coupon'] ?? false) {
            $coupon = $couponService->findCoupon($data['coupon']);

            if (!$coupon) {
                throw new InvalidCouponException($data['coupon']);
            }

            $coupon->order_id = $order->id;
            $coupon->save();
        }

        $details = $this->buildOrderDetails($order, $user, $product, $coupon);

        $response = $paymentSystem->createOrder($details);

        if (!in_array($response->status, [200, 201])) {
            logger()->error('Invalid PaymentSystem response', compact('response'));

            report(new Exception('Invalid PaymentSystem response'));

            return null;
        }

        $response = $response->content;

        $order->auto_activates = $data['auto-activates'] == true;
        $order->reference = $response->id;
        $order->init_point = $response->init_point;

        $order->save();

        event(new OrderCreated($order));

        return $response;
    }

    public function createEmpty(User $user, $duration)
    {
        $order = new Order;

        $order->duration = $duration;
        $order->user()->associate($user);

        $order->save();

        return $order;
    }

    public function buildOrderDetails(Order $order, User $user, Product $product, $coupon)
    {
        if ($coupon instanceof Coupon) {
            $ratio = 1 - $coupon->discount;
        } else {
            $ratio = 1;
        }

        $details['reason'] = "VIP de $product->duration dias nos servidores de_nerdTV";
        $details['return_url'] = route('orders.show', $order);
        $details['cancel_url'] = route('orders.show', $order);
        $details['webhook_url'] = route('api.orders.webhook', $order);
        $details['preset_amount'] = round($product->cost * $ratio);
        $details['reason'] = 'VIP servidores de_nerdTV';
        $details['product_name_singular'] = 'dia';
        $details['product_name_plural'] = 'dias';

        $details['avatar'] = $user->avatar;
        $details['payer_steam_id'] = $user->steamid;
        $details['payer_tradelink'] = $user->tradelink;

        // TODO: update this
        $details['unit_price'] = 10;
        $details['unit_price_limit'] = 5;
        $details['discount_per_unit'] = 0.08;
        $details['min_units'] = 14;
        $details['max_units'] = 90;

        return $details;
    }

    public function updateOrder(Order $order, array $values)
    {
        // TODO: improve with validator?
        $order->fill($values + ['paid' => false, 'canceled' => false]);

        $order->save();

        event(new OrderUpdated($order));

        return $order;
    }

    public function activateOrder(Order $order)
    {
        if ($order->canceled) {
            throw new OrderCanceledException;
        }

        if ($order->activated) {
            throw new OrderAlreadyActivatedException;
        }

        if (!$order->paid) {
            throw new OrderNotPaidException;
        }

        // TODO: Check if order was actually activated?
        /** @var UserService $service */
        $service = app(UserService::class);

        $basePoint = $service->getOrderBasePoint($order->user);

        $order->starts_at = $basePoint;
        $order->ends_at = $basePoint->addDays($order->duration);

        $order->save();

        event(new OrderActivated($order));

        return $order;
    }

    /**
     * @param Order $order
     * @param       $steamid
     *
     * @return bool
     */
    public function transferOrder(Order $order, $steamid)
    {
        try {
            $steamid = steamid64($steamid);
        } catch (InvalidArgumentException $e) {
            eflash()->error("<strong>%s</strong> não é uma SteamID válida!", $steamid);

            return false;
        }

        try {
            DB::beginTransaction();

            $old = $order->steamid;
            $order->steamid = $steamid;
            $order->save();

            /** @var OrderRefactoringService $service */
            $service = app(OrderRefactoringService::class);

            $service->refactorUser($order->user);
            $service->refactorSteamid($steamid);
            if ($old) {
                $service->refactorSteamid($old);
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            flash()->error("Erro ao refatorar pedidos transferidos!");

            return false;
        }
    }

    public function returnOrder(Order $order)
    {
        try {
            DB::beginTransaction();

            $old = $order->steamid;
            $order->steamid = null;
            $order->save();

            /** @var OrderRefactoringService $service */
            $service = app(OrderRefactoringService::class);
            $service->refactorSteamid($old);
            $service->refactorUser($order->user);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();

            flash()->error("Erro ao refatorar pedidos transferidos!");

            return false;
        }
    }
}
