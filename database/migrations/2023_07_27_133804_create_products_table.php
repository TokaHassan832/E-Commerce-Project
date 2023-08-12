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
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('offer_id')->nullable();
            $table->foreignId('cart_id');
            $table->string('name')->unique();
            $table->integer('original_price');
            $table->integer('discounted_price')->nullable();
            $table->json('sizes');
            $table->json('colors');
            $table->string('image')->nullable();
            //            $table->integer('rate');
            $table->text('description')->nullable();
            $table->text('details')->nullable();
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
