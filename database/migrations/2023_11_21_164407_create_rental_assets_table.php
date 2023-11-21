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

        Schema::create('rental_assets', function (Blueprint $table) {
            $table->id();
            $table->string('acumatica_asset_id', 255)->nullable();
            $table->foreignId('asset_class_id')->nullable()->constrained();
            $table->foreignId('asset_type_id')->nullable()->constrained();
            $table->foreignId('property_type_id')->nullable()->constrained();
            $table->foreignId('location_id')->nullable()->constrained();
            $table->foreignId('assigned_branch_id')->nullable()->constrained('branches');
            $table->foreignId('assigned_department_id')->nullable()->constrained('departments');
            $table->foreignId('assigned_person_id')->nullable()->constrained('users');
            $table->foreignId('status_id')->nullable()->constrained('asset_status_types');
            $table->foreignId('lienholder_id')->nullable()->constrained('asset_lienholders');
            $table->foreignId('owner_id')->nullable()->constrained('asset_owners');
            $table->string('fleet_num', 255)->nullable();
            $table->string('displayed_num', 255)->nullable();
            $table->string('old_num', 255)->nullable();
            $table->date('receipt_date')->nullable();
            $table->date('in_service_date')->nullable();
            $table->date('retired_date')->nullable();
            $table->integer('useful_life')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('description', 5000)->nullable();
            $table->integer('capacity')->nullable();
            $table->string('capacity_unit', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->string('serial_vin_num', 255)->nullable();
            $table->boolean('is_insurance_needed')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_assets');
    }
};
