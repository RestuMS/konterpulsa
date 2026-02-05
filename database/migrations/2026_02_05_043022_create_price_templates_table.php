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
        Schema::create('price_templates', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // Telkomsel, Three, Indosat, etc.
            $table->string('pattern'); // Keyword, e.g., '1,5/3h', '3,5/7h'
            $table->decimal('cost_price', 15, 2);
            $table->decimal('price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_templates');
    }
};
