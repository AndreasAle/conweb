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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::updateOrCreate(
            ['email' => 'andreasafp2@gmail.com'],
            ['name' => 'Andreas', 'password' => bcrypt('password'), 'is_admin' => true, 'email_verified_at' => now()]
        );

        $this->call([
            ContentSeeder::class,
            Phase2Seeder::class,
        ]);
    }
}
