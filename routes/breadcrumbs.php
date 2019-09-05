<?php

// Login
Breadcrumbs::for ('home', function ($trail) {
	$trail->push('Home', route('home'));
});

// Home > Servers
Breadcrumbs::for ('servers.index', function ($trail) {
	$trail->parent('home');
	$trail->push('Servers', route('servers.index'));
});