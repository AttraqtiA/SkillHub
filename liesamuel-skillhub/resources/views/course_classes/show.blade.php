@extends('layouts.app')

@section('title', 'Class Detail')

@section('content')
    <div class="grid md:grid-cols-3 gap-6">
        {{-- Class info --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-1">{{ $courseClass->title }}</h2>
                <p class="text-sm text-slate-500 mb-4">Class details</p>

                <dl class="space-y-2 text-sm">
                    <div>
                        <dt class="font-medium text-slate-700">Instructor</dt>
                        <dd class="text-slate-600">{{ $courseClass->instructor_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-700">Category</dt>
                        <dd class="text-slate-600">{{ $courseClass->category ?? '—' }}</dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <dt class="font-medium text-slate-700">Start Date</dt>
                            <dd class="text-slate-600">
                                {{ $courseClass->start_date ? \Carbon\Carbon::parse($courseClass->start_date)->format('d M Y') : '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-700">End Date</dt>
                            <dd class="text-slate-600">
                                {{ $courseClass->end_date ? \Carbon\Carbon::parse($courseClass->end_date)->format('d M Y') : '—' }}
                            </dd>
                        </div>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-700">Duration</dt>
                        <dd class="text-slate-600">
                            {{ $courseClass->duration ? $courseClass->duration . ' hours' : '—' }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <dt class="font-medium text-slate-700">Level</dt>
                            <dd class="text-slate-600">{{ ucfirst($courseClass->level ?? '—') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-700">Status</dt>
                            <dd class="text-slate-600">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs
                                    @if($courseClass->status === 'ongoing') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($courseClass->status === 'finished') bg-slate-100 text-slate-700 border border-slate-200
                                    @else bg-sky-50 text-sky-700 border border-sky-200
                                    @endif">
                                    {{ ucfirst($courseClass->status ?? 'planned') }}
                                </span>
                            </dd>
                        </div>
                    </div>
                </dl>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('course_classes.edit', $courseClass) }}"
                       class="text-xs px-3 py-2 rounded-md border border-slate-200 hover:border-skillhub-500 hover:text-skillhub-600">
                        Edit
                    </a>
                    <a href="{{ route('course_classes.index') }}"
                       class="text-xs px-3 py-2 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Enrolled participants --}}
        <div class="md:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Participants</h2>
                    <p class="text-sm text-slate-500">Participants enrolled in this class.</p>
                </div>
                <a href="{{ route('participant_classes.create') }}"
                   class="hidden sm:inline-flex items-center gap-1 text-xs px-3 py-2 rounded-md bg-skillhub-500 text-white hover:bg-skillhub-600">
                    Add Enrollment
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-slate-600">Participant</th>
                                <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Email</th>
                                <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Status</th>
                                <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Progress</th>
                                <th class="px-4 py-2 text-right font-medium text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courseClass->participants as $participant)
                                @php $pivot = $participant->pivot; @endphp
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-2">
                                        <div class="font-medium text-slate-800">
                                            <a href="{{ route('participants.show', $participant) }}"
                                               class="hover:text-skillhub-600">
                                                {{ $participant->name }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-slate-500 md:hidden">
                                            Enrolled: {{ $pivot->enrolled_at ? \Carbon\Carbon::parse($pivot->enrolled_at)->format('d M Y') : '—' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                        {{ $participant->email }}
                                    </td>
                                    <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                        {{ ucfirst($pivot->status) }}
                                    </td>
                                    <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                        {{ $pivot->progress }}%
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <form action="{{ route('participant_classes.destroy', $pivot->participant_class_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Remove this enrollment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs px-2 py-1 rounded border border-red-200 text-red-600 hover:bg-red-50">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-slate-500 text-sm">
                                        No participants enrolled in this class yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3 sm:hidden">
                <a href="{{ route('participant_classes.create') }}"
                   class="inline-flex items-center gap-1 text-xs px-3 py-2 rounded-md bg-skillhub-500 text-white hover:bg-skillhub-600">
                    Add Enrollment
                </a>
            </div>
        </div>
    </div>
@endsection
