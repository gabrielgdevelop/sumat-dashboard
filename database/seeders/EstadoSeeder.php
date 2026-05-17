<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'pendiente',
            'aceptado',
            'rechazado',
        ];

        foreach ($estados as $e) {
            DB::table('estados')->updateOrInsert(
                ['nombre' => $e],
                ['nombre' => $e, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
