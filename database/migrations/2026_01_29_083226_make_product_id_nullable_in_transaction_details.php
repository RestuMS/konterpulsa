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
        Schema::table('transaction_details', function (Blueprint $table) {
            // Drop constraint first if possible, or just modify. 
            // SQLite (often used in dev) has trouble with dropping foreign keys easily, but assuming MySQL/MariaDB or handled by Laravel.
            // Safer way: make it nullable.
            $table->foreignId('product_id')->nullable()->change();
            $table->string('product_name')->nullable()->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable(false)->change();
            $table->dropColumn('product_name');
        });
    }
};
