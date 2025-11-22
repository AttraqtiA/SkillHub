@extends('layouts.app')

@section('title', 'New Enrollment')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-slate-800">New Enrollment</h1>
            <p class="text-sm text-slate-500">Register a participant into a class.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
            <form action="{{ route('participant_classes.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Participant</label>
                        <select name="participant_id"
                                class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                            <option value="">-- Select Participant --</option>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->participant_id }}"
                                        @selected(old('participant_id') == $participant->participant_id)>
                                    {{ $participant->name }} ({{ $participant->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('participant_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Class</label>
                        <select name="courseclass_id"
                                class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->courseclass_id }}"
                                        @selected(old('courseclass_id') == $class->courseclass_id)>
                                    {{ $class->title }} ({{ $class->category ?? 'General' }})
                                </option>
                            @endforeach
                        </select>
                        @error('courseclass_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Enrolled At</label>
                        <input type="date" name="enrolled_at" value="{{ old('enrolled_at') }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('enrolled_at')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status"
                                class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                            <option value="">-- Select --</option>
                            <option value="active" @selected(old('status') === 'active')>Active</option>
                            <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                            <option value="cancelled" @selected(old('status') === 'cancelled')>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Progress (%)</label>
                        <input type="number" name="progress" value="{{ old('progress', 0) }}"
                               class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm"
                               min="0" max="100">
                        @error('progress')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Grade</label>
                    <input type="text" name="grade" value="{{ old('grade') }}"
                           class="w-full rounded-md border-slate-300 focus:border-skillhub-500 focus:ring-skillhub-500 text-sm"
                           placeholder="e.g. A, B, 90">
                    @error('grade')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('participant_classes.index') }}"
                       class="text-sm px-3 py-2 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit"
                            class="text-sm px-4 py-2 rounded-md bg-skillhub-500 text-white font-medium hover:bg-skillhub-600">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
