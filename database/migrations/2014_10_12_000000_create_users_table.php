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

			// User-friendly name
			$table->string('name')->nullable();

			// Steam username
			$table->string('username');
			// Steam tradelink
			$table->string('tradelink')->nullable();
			// SteamID64
			$table->string('steamid');
			// Steam avatar URL
			$table->string('avatar')->nullable();

			// If user is an admin
			$table->boolean('admin')->default(false);
			// If user has accepted terms of use
			$table->boolean('terms')->default(false);
			// Contact email
			$table->string('email')->unique()->nullable();

			// If user is an affiliate
			$table->boolean('affiliate')->default(false);
			// Affiliation code that is used on referral URLs
			$table->string('affiliate_code')->unique()->nullable();
			// How many days the affiliate receives when someone register using his code
			$table->unsignedInteger('affiliate_register_duration')->default(5);
			// The ratio that the affiliate will receive when someone pays an order with his code
			$table->float('affiliate_order_ratio')->default(0.5);

			// Who referred user
			$table->unsignedInteger('referrer_id')->references('id')->in('users')->nullable();

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
