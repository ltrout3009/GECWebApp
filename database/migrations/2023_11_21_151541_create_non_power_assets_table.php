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

        Schema::create('non_power_assets', function (Blueprint $table) {
            $table->id();
            $table->string('accumatica_asset_id', 255)->nullable();
            $table->foreignId('asset_class_id')->nullable()->constrained();
            $table->foreignId('asset_type_id')->nullable()->constrained();
            $table->foreignId('property_type_id')->nullable()->constrained();
            $table->foreignId('location_id')->nullable()->constrained();
            $table->foreignId('assigned_branch_id')->nullable()->constrained('branches');
            $table->foreignId('assigned_person_id')->nullable()->constrained('users');
            $table->foreignId('status_id')->nullable()->constrained('asset_status_types');
            $table->foreignId('lienholder_id')->nullable()->constrained('asset_lienholders');
            $table->foreignId('owner_id')->nullable()->constrained('asset_owners');
            $table->boolean('is_commercial_motor_vehicle')->nullable();
            $table->string('fleet_num')->nullable();
            $table->date('receipt_date')->nullable();
            $table->date('in_service_date')->nullable();
            $table->date('retired_date')->nullable();
            $table->integer('useful_life')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('description', 5000)->nullable();
            $table->integer('carrying_capacity_lbs')->nullable();
            $table->integer('gvwr')->nullable();
            $table->integer('empty_weight_lbs')->nullable();
            $table->string('color', 255)->nullable();
            $table->string('drive_tire_size', 255)->nullable();
            $table->string('steer_tire_size', 255)->nullable();
            $table->string('fuel_type', 255)->nullable();
            $table->string('transmission', 255)->nullable();
            $table->string('license_plate_num', 255)->nullable();
            $table->string('tx_tag_num', 255)->nullable();
            $table->integer('voyager_card_num')->nullable();
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
        Schema::dropIfExists('non_power_assets');
    }
};
