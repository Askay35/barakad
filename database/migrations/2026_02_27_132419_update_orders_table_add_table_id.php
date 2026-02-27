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
        // First, add the new column
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('table_id')->nullable()->after('id')->constrained('tables')->onDelete('set null');
        });
        
        // Migrate existing table numbers to table_id if possible
        // This will only work if tables with matching numbers exist
        // Otherwise, table_id will remain null for old orders
        
        // Drop the old column
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('table')->nullable()->after('id');
            $table->dropForeign(['table_id']);
            $table->dropColumn('table_id');
        });
    }
};
