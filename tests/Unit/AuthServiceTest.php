<?php

namespace Tests\Unit;

use App\Services\AuthService;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
	use DatabaseTransactions;

	protected $apiData = [
		'steamID64'   => 'STEAM_1_1:2309109',
		'personaname' => 'de_nerd',
		'avatarfull'  => 'random_url',
	];

	protected $data = [
		'steamid'  => 'STEAM_1_1:2309109',
		'username' => 'de_nerd',
		'avatar'   => 'random_url',
	];

	public function testFindOrNewUser()
	{
		Event::fake();
		/** @var AuthService $service */
		$service = app(AuthService::class);

		$user = $service->findOrNewUser((object) $this->apiData);

		Event::assertDispatched(Registered::class);
		$this->assertInstanceOf(User::class, $user);
		$this->assertDatabaseHas('users', $this->data);
		$this->assertTrue(array_diff($this->data, $user->toArray()) === []);

		Event::fake();
		$user = $service->findOrNewUser((object) $this->apiData);

		Event::assertNotDispatched(Registered::class);
		$this->assertInstanceOf(User::class, $user);
		$this->assertDatabaseHas('users', $this->data);
		$this->assertNotNull(array_diff($this->data, $user->toArray()) === []);
	}

}
