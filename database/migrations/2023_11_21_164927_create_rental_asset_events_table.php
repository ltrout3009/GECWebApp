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

        Schema::create('rental_asset_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_asset_id')->nullable()->constrained();
            $table->foreignId('rental_asset_transaction_id')->nullable()->constrained();
            $table->foreignId('event_type_id')->nullable()->constrained();
            $table->foreignId('event_status_id')->nullable()->constrained('event_status_types');
            $table->foreignId('event_interval_id')->nullable()->constrained('event_interval_types');
            $table->foreignId('waste_disposition_ts_type_id')->nullable()->constrained();
            $table->date('created_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->string('description', 5000)->nullable();
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
        Schema::dropIfExists('rental_asset_events');
    }
};
