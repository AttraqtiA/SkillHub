@extends('layouts.app')

@section('title', 'Enrollments')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Enrollments</h1>
            <p class="text-sm text-slate-500">Overview of all participant-class registrations.</p>
        </div>
        <a href="{{ route('participant_classes.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-skillhub-500 px-4 py-2 text-sm font-medium text-white hover:bg-skillhub-600">
            <span class="text-lg leading-none">＋</span> New Enrollment
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Participant</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Class</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Enrolled At</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Status</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Progress</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <div class="font-medium text-slate-800">
                                    <a href="{{ route('participants.show', $enrollment->participant) }}"
                                       class="hover:text-skillhub-600">
                                        {{ $enrollment->participant->name }}
                                    </a>
                                </div>
                                <div class="text-xs text-slate-500 md:hidden">
                                    {{ $enrollment->class->title ?? '—' }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-slate-700">
                                @if($enrollment->class)
                                    <a href="{{ route('course_classes.show', $enrollment->class) }}"
                                       class="hover:text-skillhub-600">
                                        {{ $enrollment->class->title }}
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                {{ $enrollment->enrolled_at ? \Carbon\Carbon::parse($enrollment->enrolled_at)->format('d M Y') : '—' }}
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                {{ ucfirst($enrollment->status) }}
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                {{ $enrollment->progress }}%
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('participant_classes.edit', $enrollment) }}"
                                       class="text-xs px-2 py-1 rounded border border-slate-200 hover:border-skillhub-500 hover:text-skillhub-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('participant_classes.destroy', $enrollment) }}" method="POST"
                                          onsubmit="return confirm('Delete this enrollment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs px-2 py-1 rounded border border-red-200 text-red-600 hover:bg-red-50">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500 text-sm">
                                No enrollments yet. Click “New Enrollment” to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($enrollments, 'links'))
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $enrollments->links() }}
            </div>
        @endif
    </div>
@endsection
