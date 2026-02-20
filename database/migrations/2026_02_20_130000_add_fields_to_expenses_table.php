<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('category')->default('Lainnya')->after('title');
            $table->decimal('amount', 15, 0)->after('category');
            $table->text('description')->nullable()->after('amount');
            $table->unsignedBigInteger('user_id')->nullable()->after('description');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->index('category');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['title', 'category', 'amount', 'description', 'user_id']);
        });
    }
};
