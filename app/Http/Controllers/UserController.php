<?php

namespace App\Http\Controllers;

use App\Exceptions\AffiliateCodeAlreadyLoggedException;
use App\Services\AffiliateService;
use App\Services\OrderRefactoringService;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function toggleAdmin(UserService $service, User $user)
    {
        $service->toggleAdmin($user);

        if ($user->admin) {
            eflash()->success("<strong>%s</strong> promovido para administrador!", $user->username);
        } else {
            eflash()->success("<strong>%s</strong> removido dos administradores", $user->username);
        }

        return back();
    }

    public function toggleAffiliate(UserService $service, User $user)
    {
        $service->toggleAffiliate($user);

        if ($user->affiliate) {
            eflash()->success("<strong>%s</strong> adicionado para lista de afiliados", $user->username);
        } else {
            flash()->success("<strong>%s</strong> removido da lista de afiliados", $user->username);
        }

        return back();
    }

    /**
     * @param AffiliateService $service
     * @param                  $code
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws AffiliateCodeAlreadyLoggedException
     */
    public function affiliate(AffiliateService $service, $code)
    {
        if (auth()->check()) {
            throw new AffiliateCodeAlreadyLoggedException();
        }

        if ($service->attachAffiliateCode($code)) {
            eflash()->success("Código <strong>%s</strong> registrado!", $code);
        } else {
            flash()->error('Código de afiliado inválido!');
        }

        return redirect()->route('home');
    }

    public function show(User $user)
    {
        $user->load(['orders']);

        return view('users.show', compact('user'));
    }

    public function refactor(User $user)
    {
        /** @var OrderRefactoringService $service */
        $service = app(OrderRefactoringService::class);

        $service->refactorUser($user);

        flash()->success("Pedidos do usuário <strong>{$user->steamid}</strong> refatorado!");

        return back();
    }
}
