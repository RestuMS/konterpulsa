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
        Schema::table('products', function (Blueprint $table) {
            // Index for dashboard/report queries that filter by month/year
            $table->index('created_at');
            // Index for category filtering in chart queries
            $table->index('category_id');
            // Index for stock count queries
            $table->index('stock');
            // Composite index for the most common query pattern
            $table->index(['category_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['stock']);
            $table->dropIndex(['category_id', 'created_at']);
        });
    }
};
