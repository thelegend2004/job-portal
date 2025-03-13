<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vacancy;

class VacancyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/vacancies');

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
        ];

        $response = $this->post('/vacancies', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('vacancies', $data);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function testShow()
    {
        $vacancy = Vacancy::factory()->create();

        $response = $this->get("/vacancies/{$vacancy->id}");

        $response->assertStatus(200);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function testUpdate()
    {
        $vacancy = Vacancy::factory()->create();
        $data = [
            'title' => 'Updated Vacancy',
            'description' => 'This is an updated vacancy description.',
        ];

        $response = $this->put("/vacancies/{$vacancy->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('vacancies', $data);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function testDestroy()
    {
        $vacancy = Vacancy::factory()->create();

        $response = $this->delete("/vacancies/{$vacancy->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('vacancies', ['id' => $vacancy->id]);
    }
}
