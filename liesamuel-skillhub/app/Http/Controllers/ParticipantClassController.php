<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\CourseClass;
use App\Models\ParticipantClass;
use Illuminate\Http\Request;

class ParticipantClassController extends Controller
{
    public function index()
    {
        $enrollments = ParticipantClass::with(['participant', 'class'])->paginate(10);

        return view('participant_classes.index', compact('enrollments'));
    }

    public function create()
    {
        $participants = Participant::all();
        $classes      = CourseClass::all();

        return view('participant_classes.create', compact('participants', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'participant_id' => 'required|exists:participants,participant_id',
            'courseclass_id'       => 'required|exists:courseclasses,courseclass_id',
            'enrolled_at'    => 'nullable|date',
            'status'         => 'nullable|string|max:50',
            'grade'          => 'nullable|string|max:10',
            'progress'       => 'nullable|integer|min:0|max:100',
        ]);

        if (empty($data['enrolled_at'])) {
            $data['enrolled_at'] = now();
        }

        ParticipantClass::create($data);

        return redirect()->route('participant_classes.index')
            ->with('success', 'Enrollment created successfully.');
    }

    public function show(ParticipantClass $participantClass)
    {
        $participantClass->load(['participant', 'class']);

        return view('participant_classes.show', compact('participantClass'));
    }

    public function edit(ParticipantClass $participantClass)
    {
        $participants = Participant::all();
        $classes      = CourseClass::all();

        return view('participant_classes.edit', compact('participantClass', 'participants', 'classes'));
    }

    public function update(Request $request, ParticipantClass $participantClass)
    {
        $data = $request->validate([
            'participant_id' => 'required|exists:participants,participant_id',
            'courseclass_id' => 'required|exists:courseclasses,courseclass_id',
            'enrolled_at'    => 'nullable|date',
            'status'         => 'nullable|string|max:50',
            'grade'          => 'nullable|string|max:10',
            'progress'       => 'nullable|integer|min:0|max:100',
        ]);

        $participantClass->update($data);

        return redirect()->route('participant_classes.index')
            ->with('success', 'Enrollment updated successfully.');
    }

    public function destroy(ParticipantClass $participantClass)
    {
        $participantClass->delete();

        return redirect()->route('participant_classes.index')
            ->with('success', 'Enrollment deleted successfully.');
    }
}
