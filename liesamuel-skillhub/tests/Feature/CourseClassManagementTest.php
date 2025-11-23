<?php

use App\Models\CourseClass;
use App\Models\Participant;
use App\Models\ParticipantClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

it('lists classes', function () {
    CourseClass::factory()->count(3)->create();

    $response = get(route('course_classes.index'));

    $response->assertStatus(200);
    $response->assertSeeText('Classes'); // from index heading
});

it('creates a class', function () {
    $data = [
        'title'           => 'Desain Grafis Dasar',
        'description'     => 'Belajar dasar-dasar desain grafis.',
        'instructor_name' => 'Budi Santoso',
        'start_date'      => '2025-11-01',
        'end_date'        => '2025-11-10',
        'duration'        => 20,
        'level'           => 'basic',
        'category'        => 'design',
    ];

    $response = post(route('course_classes.store'), $data);

    $response->assertRedirect(route('course_classes.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('courseclasses', [
        'title'           => 'Desain Grafis Dasar',
        'instructor_name' => 'Budi Santoso',
    ]);
});

it('shows class detail with participants', function () {
    $class       = CourseClass::factory()->create();
    $participant = Participant::factory()->create();

    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 65,
    ]);

    $response = get(route('course_classes.show', $class->courseclass_id));

    $response->assertStatus(200);
    $response->assertSeeText($class->title);
    $response->assertSeeText($participant->name); // participants table on the right
    $response->assertSeeText('65%');
});

it('updates a class', function () {
    $class = CourseClass::factory()->create([
        'title' => 'Old Title',
    ]);

    $data = [
        'title'           => 'New Title',
        'description'     => 'Updated description',
        'instructor_name' => 'New Instructor',
        'start_date'      => '2025-11-05',
        'end_date'        => '2025-11-20',
        'duration'        => 30,
        'level'           => 'advanced',
        'category'        => 'programming',
    ];

    $response = put(route('course_classes.update', $class->courseclass_id), $data);

    $response->assertRedirect(route('course_classes.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('courseclasses', [
        'courseclass_id'  => $class->courseclass_id,
        'title'           => 'New Title',
        'instructor_name' => 'New Instructor',
        'category'        => 'programming',
    ]);
});

it('deletes a class and cascades enrollments', function () {
    $class       = CourseClass::factory()->create();
    $participant = Participant::factory()->create();

    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 40,
    ]);

    delete(route('course_classes.destroy', $class->courseclass_id))
        ->assertRedirect(route('course_classes.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('courseclasses', [
        'courseclass_id' => $class->courseclass_id,
    ]);

    $this->assertDatabaseMissing('participant_classes', [
        'participant_class_id' => $enrollment->participant_class_id,
    ]);
});
