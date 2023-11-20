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

        Schema::create('pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->nullable()->constrained();
            $table->foreignId('waste_id')->nullable()->constrained();
            $table->foreignId('basis_id')->nullable()->constrained();
            $table->decimal('price',10,2)->nullable();
            $table->decimal('min_price',10,2)->nullable();
            $table->boolean('is_enterprise')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('pricings');

        Schema::enableForeignKeyConstraints();
    }
};
