@extends('layouts.app')

@section('title', 'Participant Detail')

@section('content')
    <div class="grid md:grid-cols-3 gap-6">
        {{-- Left: Participant info --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-2">{{ $participant->name }}</h2>
                <p class="text-sm text-slate-500 mb-4">Participant profile</p>

                <dl class="space-y-2 text-sm">
                    <div>
                        <dt class="font-medium text-slate-700">Email</dt>
                        <dd class="text-slate-600">{{ $participant->email }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-700">Phone</dt>
                        <dd class="text-slate-600">{{ $participant->phone_number ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-700">Gender</dt>
                        <dd class="text-slate-600">{{ $participant->gender ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-700">Birth Date</dt>
                        <dd class="text-slate-600">
                            {{ $participant->birth_date ? $participant->birth_date->format('d M Y') : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-700">Address</dt>
                        <dd class="text-slate-600">{{ $participant->address ?? '—' }}</dd>
                    </div>
                </dl>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('participants.edit', $participant) }}"
                       class="text-xs px-3 py-2 rounded-md border border-slate-200 hover:border-skillhub-500 hover:text-skillhub-600">
                        Edit
                    </a>
                    <a href="{{ route('participants.index') }}"
                       class="text-xs px-3 py-2 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Right: Enrolled classes --}}
        <div class="md:col-span-2">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Enrolled Classes</h2>
                    <p class="text-sm text-slate-500">List of classes this participant is registered in.</p>
                </div>
                <a href="{{ route('participant_classes.create') }}"
                   class="hidden sm:inline-flex items-center gap-1 text-xs px-3 py-2 rounded-md bg-skillhub-500 text-white hover:bg-skillhub-600">
                    Enroll to Class
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-slate-600">Class</th>
                                <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Status</th>
                                <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Progress</th>
                                <th class="px-4 py-2 text-right font-medium text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($participant->classes as $class)
                                @php
                                    $pivot = $class->pivot;
                                @endphp
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-2">
                                        <div class="font-medium text-slate-800">
                                            <a href="{{ route('course_classes.show', $class->courseclass_id) }}"
                                               class="hover:text-skillhub-600">
                                                {{ $class->title }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-slate-500">
                                            Enrolled at: {{ $pivot->enrolled_at ? \Carbon\Carbon::parse($pivot->enrolled_at)->format('d M Y') : '—' }}
                                        </div>
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
                                                Cancel
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-slate-500 text-sm">
                                        This participant has no classes yet.
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
                    Enroll to Class
                </a>
            </div>
        </div>
    </div>
@endsection
