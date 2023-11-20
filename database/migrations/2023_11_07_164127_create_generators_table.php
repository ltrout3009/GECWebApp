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
        Schema::create('generators', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('facility', 3)->nullable();
            $table->string('state_num',25)->nullable();
            $table->string('epa_num', 25)->nullable();
            $table->string('mailing_address')->nullable();
            $table->string('mailing_address_2')->nullable();
            $table->string('mailing_city')->nullable();
            $table->char('mailing_state', 2)->nullable();
            $table->string('mailing_zip', 10)->nullable();
            $table->string('site_address')->nullable();
            $table->string('site_address_2')->nullable();
            $table->string('site_city')->nullable();
            $table->char('site_state', 2)->nullable();
            $table->string('site_zip', 10)->nullable();
            $table->string('account_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('generators');

        Schema::enableForeignKeyConstraints();
    }
};
