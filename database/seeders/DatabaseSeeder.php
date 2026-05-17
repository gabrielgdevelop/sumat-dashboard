<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create or update a basic user for admin/testing
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'cedula' => '12345678']
        );

        // Seed parroquias and estados required by the application
        $this->call([
            ParroquiaSeeder::class,
            EstadoSeeder::class,
        ]);
    }
}
