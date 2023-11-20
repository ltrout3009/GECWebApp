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

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('generator_id')->nullable()->constrained();
            $table->integer('number')->nullable();
            $table->string('name')->nullable();
            $table->string('profile_status')->nullable();
            $table->string('description', 4500)->nullable();
            $table->string('state_waste_code_num')->nullable();
            $table->boolean('is_hazardous_waste')->nullable();
            $table->boolean('is_fed_universal_waste')->nullable();
            $table->boolean('is_state_universal_waste')->nullable();
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

        Schema::dropIfExists('profiles');

        Schema::enableForeignKeyConstraints();
    }
};
