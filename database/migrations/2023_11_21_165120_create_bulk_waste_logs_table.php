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

        Schema::create('bulk_waste_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_asset_event_id')->constrained();
            $table->foreignId('bulk_waste_container_type_id')->constrained();
            $table->double('amount', 10, 2);
            $table->string('material', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_waste_logs');
    }
};
