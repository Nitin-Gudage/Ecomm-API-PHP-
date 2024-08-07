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
        Schema::create('returnorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->integer('prize')->nullable();
            $table->string('reason')->nullable();
            $table->integer('total')->nullable();        
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->date('returnorder_date')->nullable();
            $table->integer('status')->default(1)->comment('1=>Pending,2=>Approved,3=>Processing,4=>Completed,5=>Rejected');
            //Pending, Approved, Processing, Completed, Rejected
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
        Schema::dropIfExists('returnorders');
    }
};
