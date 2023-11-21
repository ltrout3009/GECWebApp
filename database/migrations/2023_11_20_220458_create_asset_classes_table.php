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
        Schema::create('asset_classes', function (Blueprint $table) {
            $table->id();
            $table->string('acumatica_asset_class_id', 255)->nullable();
            $table->string('asset_class_name', 255)->nullable();
            $table->string('description', 4000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_classes');
    }
};
