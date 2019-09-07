<?php

// Login
Breadcrumbs::for ('home', function ($trail) {
	$trail->push('Início', route('home'));
});

// Settings
Breadcrumbs::for ('settings', function ($trail) {
	$trail->parent('home');
	$trail->push('Configurações', route('settings'));
});

// Settings
Breadcrumbs::for ('affiliates.index', function ($trail) {
	$trail->parent('home');
	$trail->push('Afiliados', route('affiliates.index'));
});

// Home > Orders
Breadcrumbs::for ('orders.index', function ($trail) {
	$trail->parent('home');
	$trail->push('Pedidos', route('orders.index'));
});

// Home > Tokens
Breadcrumbs::for ('tokens.index', function ($trail) {
	$trail->parent('home');
	$trail->push('Tokens', route('tokens.index'));
});

// Home > Tokens > Create
Breadcrumbs::for ('tokens.create', function ($trail) {
	$trail->parent('tokens.index');
	$trail->push('Criando tokens', route('tokens.create'));
});

// Home > Users
Breadcrumbs::for ('users.index', function ($trail) {
	$trail->parent('home');
	$trail->push('Usuários', route('users.index'));
});