<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->string('name')->nullable();
			$table->string('username');

			$table->string('tradelink')->nullable();

			$table->string('steamid');
			$table->string('avatar')->nullable();

			$table->boolean('admin')->default(false);
			$table->boolean('terms')->default(false);

			$table->string('email')->unique()->nullable();

			$table->string('affiliate_code')->nullable();
	
			$table->unsignedInteger('referrer_id')->nullable();
			$table->dateTime('referred_at')->nullable();

			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
