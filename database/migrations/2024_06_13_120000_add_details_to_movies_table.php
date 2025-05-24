<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('image')->nullable()->after('poster_path');
            $table->string('director', 128)->nullable()->after('description');
            $table->integer('duration_minutes')->nullable()->after('director');
            $table->date('release_date')->nullable()->after('duration_minutes');
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn(['image', 'director', 'duration_minutes', 'release_date']);
        });
    }
};
