<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('committee_members', function (Blueprint $table) {
            $table->string('board')->default('EXECUTIVE')->after('is_current');
            $table->index(['board', 'is_current', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::table('committee_members', function (Blueprint $table) {
            $table->dropIndex(['board', 'is_current', 'sort_order']);
            $table->dropColumn('board');
        });
    }
};
