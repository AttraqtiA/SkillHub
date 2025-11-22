<?php

use App\Models\Participant;
use App\Models\CourseClass;
use App\Models\ParticipantClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

it('lists participants', function () {
    Participant::factory()->count(3)->create();

    $response = get(route('participants.index'));

    $response->assertStatus(200);
    $response->assertSeeText('Participants'); // from index view heading
});

it('creates a participant', function () {
    $data = [
        'name'         => 'John Doe',
        'email'        => 'john@example.com',
        'phone_number' => '08123456789',
        'address'      => 'Jl. Mawar No. 1',
        'birth_date'   => '1995-01-10',
        'gender'       => 'Male',
    ];

    $response = post(route('participants.store'), $data);

    $response->assertRedirect(route('participants.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('participants', [
        'email' => 'john@example.com',
        'name'  => 'John Doe',
    ]);
});

it('shows participant detail with enrolled classes', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    // enrollment
    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 50,
    ]);

    $response = get(route('participants.show', $participant->participant_id));

    $response->assertStatus(200);
    $response->assertSeeText($participant->name);
    $response->assertSeeText($class->title);      // class list on the right
    $response->assertSeeText('50%');              // progress from pivot
});

it('updates a participant', function () {
    $participant = Participant::factory()->create([
        'name'  => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $data = [
        'name'         => 'New Name',
        'email'        => 'new@example.com',
        'phone_number' => '089999999',
        'address'      => 'New Address',
        'birth_date'   => '1990-05-05',
        'gender'       => 'Female',
    ];

    $response = put(route('participants.update', $participant->participant_id), $data);

    $response->assertRedirect(route('participants.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('participants', [
        'participant_id' => $participant->participant_id,
        'name'           => 'New Name',
        'email'          => 'new@example.com',
    ]);
});

it('deletes a participant and cascades enrollments', function () {
    $participant = Participant::factory()->create();
    $class       = CourseClass::factory()->create();

    $enrollment = ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $class->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 80,
    ]);

    delete(route('participants.destroy', $participant->participant_id))
        ->assertRedirect(route('participants.index'))
        ->assertSessionHas('success');

    // participant removed
    $this->assertDatabaseMissing('participants', [
        'participant_id' => $participant->participant_id,
    ]);

    // enrollment removed by ON DELETE CASCADE
    $this->assertDatabaseMissing('participant_classes', [
        'participant_class_id' => $enrollment->participant_class_id,
    ]);
});

it('shows all classes a participant is enrolled in', function () {
    $participant = \App\Models\Participant::factory()->create();

    $classA = \App\Models\CourseClass::factory()->create(['title' => 'Desain Grafis']);
    $classB = \App\Models\CourseClass::factory()->create(['title' => 'Public Speaking']);

    \App\Models\ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $classA->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 30,
    ]);

    \App\Models\ParticipantClass::create([
        'participant_id' => $participant->participant_id,
        'courseclass_id' => $classB->courseclass_id,
        'enrolled_at'    => now(),
        'status'         => 'active',
        'grade'          => null,
        'progress'       => 70,
    ]);

    $response = get(route('participants.show', $participant->participant_id));

    $response->assertStatus(200);
    $response->assertSeeText('Desain Grafis');
    $response->assertSeeText('Public Speaking');
});
