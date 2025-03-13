<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VacancyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_vacancy()
    {
        $vacancy = Vacancy::factory()->create([
            'title' => 'PHP Developer',
            'department_id' => 1,
            'description' => 'Some description',
        ]);

        $this->assertDatabaseHas('vacancies', [
            'title' => 'PHP Developer',
        ]);
    }

    /** @test */
    public function it_can_update_a_vacancy()
    {
        $vacancy = Vacancy::factory()->create();
        $vacancy->update(['title' => 'Updated Title']);

        $this->assertDatabaseHas('vacancies', ['title' => 'Updated Title']);
    }

    /** @test */
    public function it_can_delete_a_vacancy()
    {
        $vacancy = Vacancy::factory()->create();
        $vacancy->delete();

        $this->assertDatabaseMissing('vacancies', ['id' => $vacancy->id]);
    }
}
