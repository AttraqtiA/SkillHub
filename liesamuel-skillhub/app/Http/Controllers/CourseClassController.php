<?php

namespace App\Http\Controllers;

use App\Models\CourseClass;
use Illuminate\Http\Request;

class CourseClassController extends Controller
{
    public function index()
    {
        $classes = CourseClass::paginate(10);

        return view('course_classes.index', compact('classes'));
    }

    public function create()
    {
        return view('course_classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:150',
            'description'     => 'nullable|string|max:255',
            'instructor_name' => 'nullable|string|max:100',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'status'          => 'nullable|string|max:50',
            'duration'        => 'nullable|integer|min:0',
            'level'           => 'nullable|string|max:50',
            'category'        => 'nullable|string|max:50',
        ]);

        CourseClass::create($data);

        return redirect()->route('course_classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function show(CourseClass $courseClass)
    {
        $courseClass->load('participants');
        return view('course_classes.show', compact('courseClass'));
    }

    public function edit(CourseClass $courseClass)
    {
        return view('course_classes.edit', compact('courseClass'));
    }

    public function update(Request $request, CourseClass $courseClass)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:150',
            'description'     => 'nullable|string|max:255',
            'instructor_name' => 'nullable|string|max:100',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'status'          => 'nullable|string|max:50',
            'duration'        => 'nullable|integer|min:0',
            'level'           => 'nullable|string|max:50',
            'category'        => 'nullable|string|max:50',
        ]);

        $courseClass->update($data);

        return redirect()->route('course_classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(CourseClass $courseClass)
    {
        $courseClass->delete();

        return redirect()->route('course_classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}
