<?php

namespace Tests\Unit;

use App\Admin;
use App\Services\AdminService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
	use DatabaseTransactions;

	protected $original = [
		'username' => 'admin',
		'steamid'  => 'STEAM_1_1:1232923',
		'flags'    => 'abc',
		'note'     => 'note test',
	];

	protected $updated = [
		'username' => 'admin new name',
		'steamid'  => 'STEAM_1_1:82492893',
		'flags'    => 'zac',
		'note'     => 'new note',
	];

	public function testStoreAndUpdateAdmin()
	{
		/** @var AdminService $service */
		$service = app(AdminService::class);

		$admin = $service->storeAdmin($this->original);

		$this->assertInstanceOf(Admin::class, $admin);
		$this->assertDatabaseHas('admins', $this->original);
		$this->assertTrue(array_diff($this->original, $admin->toArray()) === []);

		$admin = $service->updateAdmin($admin, $this->updated);

		$this->assertInstanceOf(Admin::class, $admin);
		$this->assertDatabaseHas('admins', $this->updated);
		$this->assertTrue(array_diff($this->updated, $admin->toArray()) === []);
	}
}
