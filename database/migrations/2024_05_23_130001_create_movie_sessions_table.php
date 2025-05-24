<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->dateTime('session_datetime');
            $table->unsignedInteger('price')->default(300);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_sessions');
    }
};
