<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('notes_en')->nullable();
            $table->text('notes_si')->nullable();
            $table->text('notes_ta')->nullable();
            $table->string('host_name');
            $table->string('host_address');
            $table->timestamp('held_at');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->index(['is_published', 'held_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_meetings');
    }
};
