<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyUsedTokenException;
use App\Exceptions\TokenExpiredException;
use App\Http\Requests\TokenStoreRequest;
use App\Http\Requests\TokenUpdateRequest;
use App\Order;
use App\Token;
use App\TokenForm;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;

class TokenController extends Controller
{
	public function index()
	{
		$user = auth()->user();

		if ($user->admin) {
			$tokens = Token::query();
		} else {
			$tokens = $user->tokens();
		}

		$tokens = $tokens->with(['user'])->get();

		return view('tokens.index', compact('tokens'));
	}

	public function show(Token $token)
	{
		return view('tokens.show', compact('token'));
	}

	public function use(Token $token)
	{
		if ($token->order !== null)
			throw new AlreadyUsedTokenException('Token already used.');

		if ($token->expires_at && $token->expires_at->isPast())
			throw new TokenExpiredException('Expired tokens cannot be used');

		// TODO: move to service layer
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
         }

         DB::commit();

		flash()->success('Token registrado com sucesso!');

		return redirect()->route('orders.show', $order);
	}

	public function create(FormBuilder $builder)
	{
		$form = $builder->create(TokenForm::class, [
			'method' => 'POST',
			'url'    => route('tokens.store'),
		]);

		return view('form', [
			'title'       => 'Criando novo token',
			'form'        => $form,
			'submit_text' => 'Criar',
		]);
	}

	public function store(TokenStoreRequest $request)
	{
		$token = new Token();

		$token->fill($request->validated());
		$token->reason()->associate(auth()->user());

		$token->save();

		return redirect()->route('tokens.show', $token);
	}

	public function update(TokenUpdateRequest $request, Token $token)
	{
		$token->fill($request->validated());

		$token->save();

		return $token;
	}

	public function destroy(Token $token)
	{
		$token->delete();

		return $token;
	}
}
