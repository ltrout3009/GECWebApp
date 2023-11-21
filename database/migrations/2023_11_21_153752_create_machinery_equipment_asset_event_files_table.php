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

        Schema::create('machinery_equipment_asset_event_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machinery_equipment_asset_event_id')->constrained();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machinery_equipment_asset_event_files');
    }
};
