<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->string('id')->unique();

			// How many days this order gives
			$table->unsignedInteger('duration');

			// Owner overwrite
			$table->string('steamid')->nullable();

			// When order was activated
			$table->timestamp('starts_at')->nullable();
			// When order will expire
			$table->timestamp('ends_at')->nullable();
			// When order was synchronized
			$table->timestamp('synced_at')->nullable();

			// PaymentSystem ID reference
			$table->string('reference')->nullable();
			// PaymentSystem init URL
			$table->string('init_point')->nullable();

			// If order is paid (generally provided by PaymentSystem's API)
			$table->boolean('paid')->default(false);
			// If order was canceled (manually set)
			$table->boolean('canceled')->default(false);
			// If owner set automatic activation
			$table->boolean('auto_activate')->default(false);
			// How many times we had to recheck the order
			$table->unsignedInteger('recheck_attempts')->default(0);

			// User that owns the order
			$table->unsignedInteger('user_id')->references('id')->on('users');

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
		Schema::dropIfExists('orders');
	}
}
