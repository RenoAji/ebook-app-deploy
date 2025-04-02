<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(2)->create();
        // \App\Models\Book::factory(5)->create();
        // \App\Models\User::factory()->create([
        //     'username' => 'reno',
        //     'email' => 'renoaji25sep@example.com',
        //     'password' => bcrypt('reno12345'),
        // ]);
        \App\Models\User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('passadmin'),
            'is_admin' => true,
        ]);
    }
}
