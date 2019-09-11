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

			// How many days the token will generate
			$table->unsignedInteger('duration');

			// Token note
			$table->text('note');

			// User that owns this token (admin who generated or affiliate that received the token)
			$table->unsignedInteger('user_id')->nullable()->references('id')->on('users');
			// Order that was created by this token
			$table->string('order_id')->nullable()->references('id')->on('orders');

			// Custom morphsTo() using string as `reason_id`
			$table->string('reason_type');
			$table->string('reason_id');
			$table->index(['reason_type', 'reason_id']);

			// When this token expires
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
