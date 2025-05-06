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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('row_id');
            $table->string('order_id', 50);
            $table->date('order_date');
            $table->date('ship_date');
            $table->string('ship_mode', 50);
            $table->string('customer_id');
            $table->string('segment', 50);
            $table->string('postal_code', 10);
            $table->string('product_id');
            $table->decimal('sales', 10, 6);
            $table->integer('quantity');
            $table->decimal('discount', 5, 6);
            $table->decimal('profit', 10, 6);
            $table->timestamps();

            // Claves foráneas
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('postal_code')->references('postal_code')->on('location')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
