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

        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wpc_id')->nullable()->constrained();
            $table->foreignId('facility_id')->nullable()->constrained();
            $table->string('vendor_code')->nullable();
            $table->boolean('is_case_by_case')->nullable();
            $table->boolean('is_enterprise')->nullable();
            $table->boolean('is_custom_entry')->nullable();
            $table->foreignId('container_id')->nullable()->constrained();
            $table->foreignId('basis_id')->nullable()->constrained();
            $table->decimal('cost', 10,2)->nullable();
            $table->decimal('min_cost',10,2)->nullable();
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

        Schema::dropIfExists('wastes');

        Schema::enableForeignKeyConstraints();
    }
};
