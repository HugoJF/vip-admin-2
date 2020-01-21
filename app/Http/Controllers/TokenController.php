<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadyUsedTokenException;
use App\Exceptions\TokenExpiredException;
use App\Http\Requests\TokenStoreRequest;
use App\Http\Requests\TokenUpdateRequest;
use App\Services\TokenService;
use App\Token;
use App\TokenForm;
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

    public function use(TokenService $service, Token $token)
    {
        if ($token->used)
            throw new AlreadyUsedTokenException($token);

        if ($token->expired)
            throw new TokenExpiredException($token);

        $order = $service->use($token);

        if ($order)
            return redirect()->route('orders.show', $order);
        else
            return back();
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

    public function store(TokenService $service, TokenStoreRequest $request)
    {
        $token = $service->create($request->validated());

        eflash()->success("Token <strong>%s</strong> criado com sucesso!", $token->id);

        return redirect()->route('tokens.show', $token);
    }

    public function update(TokenService $service, TokenUpdateRequest $request, Token $token)
    {
        $service->update($token, $request->validated());

        eflash()->success("Token <strong>%s</strong> atualizado com sucesso!", $token->id);

        return redirect()->route('tokens.show', $token);
    }

    public function destroy(TokenService $service, Token $token)
    {
        $service->delete($token);

        eflash()->success("Token <strong>%s</strong> removido com sucesso!", $token->id);

        return redirect()->route('tokens.index');
    }
}
