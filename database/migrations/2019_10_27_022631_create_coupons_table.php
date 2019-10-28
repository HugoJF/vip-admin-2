<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function (Blueprint $table) {
			$table->bigIncrements('id');

			// Coupon code
			$table->string('code');
			// Discount percentage
			$table->float('discount');
			// When coupon starts to be valid
			$table->dateTime('starts_at');
			// When coupon expires
			$table->dateTime('ends_at');

			// Order where coupon was used
			$table->string('order_id')->references('id')->on('orders')->nullable();

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
		Schema::dropIfExists('coupons');
	}
}
