<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParroquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parroquias = [
            'Cumanacoa',
            'Arenas',
            'Aricagua',
            'San Fernando',
            'San Lorenzo',
            'Cocollar',
        ];

        foreach ($parroquias as $p) {
            DB::table('parroquias')->updateOrInsert(
                ['nombre' => $p],
                ['nombre' => $p, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
