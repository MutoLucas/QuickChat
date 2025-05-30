<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_who_blocked_id')->constrained('users','id')->onDelete('cascade');
            $table->foreignId('user_blocked_id')->constrained('users','id')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_who_blocked_id','user_blocked_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
