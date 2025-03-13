<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_departments()
    {
        Department::factory()->count(3)->create();
        $response = $this->getJson('/api/departments');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    /** @test */
    public function it_can_create_a_department()
    {
        $response = $this->postJson('/api/departments', [
            'name' => 'New Department',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('departments', ['name' => 'New Department']);
    }
}
