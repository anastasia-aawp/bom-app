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
        Schema::create('trans_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->integer('price')->default(0);
            $table->integer('total_price')->default(0);
            $table->integer('qty')->default(0);
            $table->text('materials')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('mst_products');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_products');
    }
};
