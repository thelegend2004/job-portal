<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        Department::factory(5)->create()->each(function ($department) {
            $department->vacancies()->saveMany(
                Vacancy::factory(3)->make()
            );
        });
    }
}
