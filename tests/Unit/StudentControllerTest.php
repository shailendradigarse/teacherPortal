<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Student;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreNewStudent()
    {
        $response = $this->postJson('/students', [
            'name' => 'John Doe',
            'subject' => 'Math',
            'marks' => 90
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => 'Student added successfully']);

        $this->assertDatabaseHas('students', [
            'name' => 'John Doe',
            'subject' => 'Math',
            'marks' => 90
        ]);
    }

    public function testUpdateExistingStudent()
    {
        $student = Student::create([
            'name' => 'Jane Doe',
            'subject' => 'Science',
            'marks' => 85
        ]);

        $response = $this->putJson("/students/{$student->id}", [
            'marks' => 95
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => 'Student updated successfully']);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'marks' => 95
        ]);
    }

    public function testDestroyStudent()
    {
        $student = Student::create([
            'name' => 'Mark Smith',
            'subject' => 'History',
            'marks' => 70
        ]);

        $response = $this->deleteJson("/students/{$student->id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => 'Student deleted successfully']);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id
        ]);
    }

    public function testStoreValidationErrors()
    {
        $response = $this->postJson('/students', [
            'name' => '',
            'subject' => '',
            'marks' => 'invalid'
        ]);

        $response->assertStatus(422)
                 ->assertJson(['error' => 'The name field is required.']);
    }
}
