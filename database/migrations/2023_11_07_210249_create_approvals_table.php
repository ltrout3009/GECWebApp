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

        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->nullable()->constrained();
            $table->foreignId('facility_id')->nullable()->constrained();
            $table->boolean('is_primary_facility')->nullable();
            $table->string('number')->nullable();
            $table->string('approval_status')->nullable();
            $table->date('expiration')->nullable();
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

        Schema::dropIfExists('approvals');

        Schema::enableForeignKeyConstraints();
    }
};
