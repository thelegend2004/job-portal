<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vacancy;
use App\Models\Department;

class VacancyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the departments table
        Department::factory()->create(['id' => 1]);

        // Disable middleware for testing
        $this->withoutMiddleware();
    }

    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/vacancies');

        $response->assertStatus(200);
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'title' => 'Test Vacancy',
            'description' => 'This is a test vacancy description.',
            'requirements' => ['PHP', 'Laravel', 'MySQL'],
            'benefits' => ['Medical Insurance', 'Remote Work'],
            'min_salary' => 500,
            'max_salary' => 2000,
            'contact_name' => 'John Doe',
            'contact_phone' => '+1234567890',
            'department_id' => 1,
            'is_hot' => true,
            'published_from' => now(),
            'published_to' => now()->addMonth(),
        ];

        $response = $this->post('/api/vacancies', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('vacancies', [
            'title' => 'Test Vacancy',
            'description' => 'This is a test vacancy description.',
        ]);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function testShow()
    {
        $vacancy = Vacancy::factory()->create();

        $response = $this->get("/api/vacancies/{$vacancy->id}");

        $response->assertStatus(200);
    }
}
