<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceptedorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orderitem_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->string('payment_status');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->integer('tracking_id');
            $table->integer('quantity');
            $table->foreign('orderitem_id')->references('id')->on('orderitems');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('product_id')->references('id')->on('products');

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
        Schema::dropIfExists('acceptedorders');
    }
};
