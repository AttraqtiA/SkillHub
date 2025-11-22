<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CourseClassController;
use App\Http\Controllers\ParticipantClassController;

Route::get('/', function () {
    return redirect()->route('participants.index');
});

Route::resource('participants', ParticipantController::class);

Route::resource('course-classes', CourseClassController::class)
    ->names('course_classes');

Route::resource('participant-classes', ParticipantClassController::class)
    ->names('participant_classes');

