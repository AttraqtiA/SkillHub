<?php

use App\Models\Participant;
use App\Models\CourseClass;
use App\Models\ParticipantClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

it('lists enrollments', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 10,
    ]);

    $response = get(route('participant_classes.index'));

    $response->assertStatus(200);
    $response->assertSeeText('Enrollments'); // heading in index view
});

it('creates an enrollment', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    $data = [
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now()->format('Y-m-d'),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 0,
    ];

    $response = post(route('participant_classes.store'), $data);

    $response->assertRedirect(route('participant_classes.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('participant_classes', [
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'status'         => 'active',
    ]);
});

it('shows a single enrollment detail', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'completed',
        'grade'          => 'A',
        'progress'       => 100,
    ]);

    $response = get(route('participant_classes.show', $enrollment->participant_class_id));

    $response->assertStatus(200);
    $response->assertSeeText($participant->name);
    $response->assertSeeText($class->title);
    $response->assertSeeText('Completed');
    $response->assertSeeText('100');
});

it('updates an enrollment', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 0,
    ]);

    $data = [
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now()->format('Y-m-d'),
        'status'         => 'completed',
        'grade'          => 'A',
        'progress'       => 100,
    ];

    $response = put(route('participant_classes.update', $enrollment->participant_class_id), $data);

    $response->assertRedirect(route('participant_classes.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('participant_classes', [
        'participant_class_id' => $enrollment->participant_class_id,
        'status'               => 'completed',
        'grade'                => 'A',
        'progress'             => 100,
    ]);
});

it('deletes an enrollment (cancel from a class)', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 25,
    ]);

    delete(route('participant_classes.destroy', $enrollment->participant_class_id))
        ->assertRedirect(route('participant_classes.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('participant_classes', [
        'participant_class_id' => $enrollment->participant_class_id,
    ]);
});
