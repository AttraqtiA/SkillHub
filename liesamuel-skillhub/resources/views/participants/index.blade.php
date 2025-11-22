@extends('layouts.app')

@section('title', 'Participants')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Participants</h1>
            <p class="text-sm text-slate-500">Manage all registered SkillHub participants.</p>
        </div>
        <a href="{{ route('participants.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-skillhub-500 px-4 py-2 text-sm font-medium text-white hover:bg-skillhub-600">
            <span class="text-lg leading-none">＋</span> New Participant
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Name</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Email</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Phone</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Gender</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participants as $participant)
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <div class="font-medium text-slate-800">
                                    <a href="{{ route('participants.show', $participant) }}"
                                       class="hover:text-skillhub-600">
                                        {{ $participant->name }}
                                    </a>
                                </div>
                                <div class="text-xs text-slate-500 md:hidden">
                                    {{ $participant->email }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                {{ $participant->email }}
                            </td>
                            <td class="px-4 py-2 text-slate-700">
                                {{ $participant->phone_number ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                {{ $participant->gender ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('participants.edit', $participant) }}"
                                       class="text-xs px-2 py-1 rounded border border-slate-200 hover:border-skillhub-500 hover:text-skillhub-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('participants.destroy', $participant) }}" method="POST"
                                          onsubmit="return confirm('Delete this participant? This will also remove their enrollments.');">
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
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500 text-sm">
                                No participants yet. Click “New Participant” to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($participants, 'links'))
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $participants->links() }}
            </div>
        @endif
    </div>
@endsection
