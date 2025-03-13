<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'requirements' => ['PHP', 'Laravel', 'MySQL'],
            'benefits' => ['Medical Insurance', 'Remote Work'],
            'min_salary' => $this->faker->numberBetween(500, 1500),
            'max_salary' => $this->faker->numberBetween(2000, 5000),
            'contact_name' => $this->faker->name,
            'contact_phone' => $this->faker->phoneNumber,
            'department_id' => Department::inRandomOrder()->first()->id ?? 1,
            'is_hot' => $this->faker->boolean,
            'published_from' => now(),
            'published_to' => now()->addMonth(),
        ];
    }
}
