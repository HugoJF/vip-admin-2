<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tokens', function (Blueprint $table) {
			$table->string('id')->unique();

			$table->unsignedInteger('duration');

			$table->text('note');

			$table->unsignedInteger('user_id')->nullable()->references('id')->on('users');
			$table->string('order_id')->nullable()->references('id')->on('orders');

			$table->timestamp('expires_at')->nullable();
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
		Schema::dropIfExists('tokens');
	}
}
