@extends('layouts.app')

@section('title', 'Edit Class')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-slate-800">Edit Class</h1>
            <p class="text-sm text-slate-500">Update class information.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
            <form action="{{ route('course_classes.update', $courseClass) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" value="{{ old('title', $courseClass->title) }}"
                           class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                    @error('title')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">{{ old('description', $courseClass->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Instructor Name</label>
                        <input type="text" name="instructor_name" value="{{ old('instructor_name', $courseClass->instructor_name) }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('instructor_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                        <input type="text" name="category" value="{{ old('category', $courseClass->category) }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('category')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $courseClass->start_date) }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('start_date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $courseClass->end_date) }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('end_date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Duration (hours)</label>
                        <input type="number" name="duration" value="{{ old('duration', $courseClass->duration) }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm" min="0">
                        @error('duration')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Level</label>
                        <select name="level"
                                class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                            <option value="">-- Select --</option>
                            <option value="basic" @selected(old('level', $courseClass->level) === 'basic')>Basic</option>
                            <option value="intermediate" @selected(old('level', $courseClass->level) === 'intermediate')>Intermediate</option>
                            <option value="advanced" @selected(old('level', $courseClass->level) === 'advanced')>Advanced</option>
                        </select>
                        @error('level')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status"
                                class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                            <option value="">-- Select --</option>
                            <option value="planned" @selected(old('status', $courseClass->status) === 'planned')>Planned</option>
                            <option value="ongoing" @selected(old('status', $courseClass->status) === 'ongoing')>Ongoing</option>
                            <option value="finished" @selected(old('status', $courseClass->status) === 'finished')>Finished</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('course_classes.index') }}"
                       class="text-sm px-3 py-2 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit"
                            class="text-sm px-4 py-2 rounded-md bg-skillhub-500 text-white font-medium hover:bg-skillhub-600">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
