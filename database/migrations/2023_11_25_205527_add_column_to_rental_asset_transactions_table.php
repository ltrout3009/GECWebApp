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
        Schema::table('rental_asset_transactions', function (Blueprint $table) {
            $table->text('off_rent_notes')->nullable()->after('transaction_notes');

            $table->renameColumn('transaction_notes','on_rent_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rental_asset_transactions', function (Blueprint $table) {
            $table->dropColumn('off_rent_notes');

            $table->renameColumn('on_rent_notes','transaction_notes');
        });
    }
};
