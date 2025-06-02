<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('purchases', function (Blueprint $table) {
        $table->id();
        $table->foreignId('products_id')->constrained()->onDelete('cascade');
        $table->foreignId('customers_id')->constrained()->onDelete('cascade');
        $table->integer('quantity');
        $table->decimal('total', 10, 2);
        $table->timestamps();

        $table->foreign('user_id')->constrained('users')->onDelete('cascade');
        $table->foreign('customers_id')->references('id')->on('customers')->onDelete('cascade');
        $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
