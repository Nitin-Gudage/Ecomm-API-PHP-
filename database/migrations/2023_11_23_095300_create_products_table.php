<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->integer('mrp')->nullable();
            $table->integer('sale_price')->nullable();
            $table->string('heading')->nullable();
            $table->string('discription')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('min_quantity')->default(1);
            $table->integer('max_quantity')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('thumbnail')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
