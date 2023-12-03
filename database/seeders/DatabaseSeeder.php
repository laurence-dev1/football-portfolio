<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory([
            'name'     => 'Laurence',
            'username' => 'laurence',
            'email'    => 'laurence@test.com',
            'password' => bcrypt('123')
        ])->create();

        User::factory(4)->create();
    }
}
