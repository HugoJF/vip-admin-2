<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

		factory(\App\User::class, 50)->create();
		factory(\App\Order::class, 50)->create();
		factory(\App\Token::class, 25)->create();
    }
}
