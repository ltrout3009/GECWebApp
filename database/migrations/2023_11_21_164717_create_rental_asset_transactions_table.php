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
        Schema::disableForeignKeyConstraints();

        Schema::create('rental_asset_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_asset_id')->constrained();
            $table->foreignId('generator_id')->constrained();
            $table->date('on_rent_date')->nullable();
            $table->date('off_rent_date')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('delivery_order_num')->nullable();
            $table->integer('pickup_order_num')->nullable();
            $table->string('transaction_notes', 5000)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_asset_transactions');
    }
};
