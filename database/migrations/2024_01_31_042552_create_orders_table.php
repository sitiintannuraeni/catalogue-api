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
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_number');
            $table->integer('total_quantity');
            $table->integer('total_price');
            $table->enum('status', ['New', 'Pending Payment', 'Processing', 'Shipped', 'Delivered', 'Completed', 'Cancelled', 'On Hold', 'Failed', 'Returned', 'Refunded'])
            ->default('New');
            $table->timestamps();
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
