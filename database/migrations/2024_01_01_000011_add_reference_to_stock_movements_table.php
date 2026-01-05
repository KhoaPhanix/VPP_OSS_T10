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
        // Check if columns already exist before adding
        if (!Schema::hasColumn('stock_movements', 'reference_type')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->string('reference_type', 50)->nullable()->after('quantity_after');
            });
        }
        
        if (!Schema::hasColumn('stock_movements', 'reference_id')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->unsignedBigInteger('reference_id')->nullable()->after('reference_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropColumn(['reference_type', 'reference_id']);
        });
    }
};
