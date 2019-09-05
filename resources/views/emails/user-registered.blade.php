@component('mail::message')
# {{ $user->username }} acabou de registrar!

@component('mail::button', ['url' => route('users.index') ])
Lista de usuários
@endcomponent
@endcomponent
