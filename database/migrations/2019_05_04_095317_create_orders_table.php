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

			$table->unsignedInteger('duration');

			$table->timestamp('starts_at')->nullable();
			$table->timestamp('ends_at')->nullable();
			$table->timestamp('synced_at')->nullable();

			$table->string('reference')->nullable();

			$table->boolean('paid')->default(false);
			$table->boolean('canceled')->default(false);
			$table->boolean('auto_activate')->default(false);
			$table->unsignedInteger('recheck_attempts')->default(0);

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
