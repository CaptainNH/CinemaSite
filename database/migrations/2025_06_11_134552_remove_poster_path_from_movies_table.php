<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            // Проверяем существование столбца перед удалением
            if (Schema::hasColumn('movies', 'poster_path')) {
                $table->dropColumn('poster_path');
            }
        });
    }

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            // При откате миграции восстанавливаем поле
            $table->string('poster_path')->nullable()->after('image');
        });
    }
};
