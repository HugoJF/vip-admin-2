<?php

namespace App\Services;

use App\Order;
use App\Token;
use Exception;
use Illuminate\Support\Facades\DB;

class TokenService
{
    public function use(Token $token)
    {
        DB::beginTransaction();

        $order = new Order();

        try {
            $order->id = "to$token->id";
            $order->duration = $token->duration;

            $order->paid = true;
            $order->canceled = false;

            $order->user()->associate(auth()->user());
            $token->order()->associate($order);

            $order->save();
            $token->save();
        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            $message = e($e->getMessage());

            flash()->error("Erro ao registrar uso do token: $message");

            return null;
        }

        DB::commit();

        flash()->success('Token registrado com sucesso!');

        return $order;
    }

    public function create(array $data)
    {
        $token = new Token();

        $token->fill($data);
        $token->reason()->associate(auth()->user());

        $token->save();

        return $token;
    }

    public function update(Token $token, array $data)
    {
        $token->fill($data);

        $token->save();

        return $token;
    }

    public function delete(Token $token)
    {
        $token->delete();
    }
}
