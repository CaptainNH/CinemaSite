<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('movies')->insert([
            [
                'title' => 'Интерстеллар',
                'description' => 'Космическая одиссея о выживании человечества.',
                'director' => 'Кристофер Нолан',
                'duration_minutes' => 169,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Форрест Гамп',
                'description' => 'История об удивительных приключениях простого американца.',
                'director' => 'Роберт Земекис',
                'duration_minutes' => 142,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'М��трица',
                'description' => 'Мир иллюзий и борьба против системы.',
                'director' => 'Вачовски',
                'duration_minutes' => 136,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
