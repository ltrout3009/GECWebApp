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

        Schema::create('machinery_equipment_asset_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machinery_equipment_asset_id')->constrained();
            $table->foreignId('event_type_id')->constrained();
            $table->foreignId('event_status_id')->constrained('event_status_types');
            $table->foreignId('event_interval_id')->constrained('event_interval_types');
            $table->date('created_date');
            $table->date('due_date');
            $table->date('start_date');
            $table->date('completed_date');
            $table->string('description', 5000)->nullable();
            $table->integer('mileage')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machinery_equipment_asset_events');
    }
};
