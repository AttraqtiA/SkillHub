<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::paginate(10);

        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:100|unique:participants,email',
            'phone_number' => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'birth_date'   => 'nullable|date',
            'gender'       => 'nullable|string|max:10',
        ]);

        Participant::create($data);

        return redirect()->route('participants.index')
            ->with('success', 'Participant created successfully.');
    }

    public function show(Participant $participant)
    {
        $participant->load('classes');
        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'email'        => 'required|email|max:100|unique:participants,email,' . $participant->participant_id . ',participant_id',
            'phone_number' => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'birth_date'   => 'nullable|date',
            'gender'       => 'nullable|string|max:10',
        ]);

        $participant->update($data);

        return redirect()->route('participants.index')
            ->with('success', 'Participant updated successfully.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()->route('participants.index')
            ->with('success', 'Participant deleted successfully.');
    }
}
