@extends('layouts.app')

@section('title', 'Classes')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Classes</h1>
            <p class="text-sm text-slate-500">Manage all training classes in SkillHub.</p>
        </div>
        <a href="{{ route('course_classes.create') }}"
           class="inline-flex items-center gap-2 rounded-md bg-skillhub-500 px-4 py-2 text-sm font-medium text-white hover:bg-skillhub-600">
            <span class="text-lg leading-none">＋</span> New Class
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Title</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600">Category</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Level</th>
                        <th class="px-4 py-2 text-left font-medium text-slate-600 hidden md:table-cell">Status</th>
                        <th class="px-4 py-2 text-right font-medium text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <div class="font-medium text-slate-800">
                                    <a href="{{ route('course_classes.show', $class) }}"
                                       class="hover:text-skillhub-600">
                                        {{ $class->title }}
                                    </a>
                                </div>
                                <div class="text-xs text-slate-500 md:hidden">
                                    {{ $class->category ?? 'Uncategorized' }} • {{ ucfirst($class->status ?? 'planned') }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-slate-700">
                                {{ $class->category ?? '—' }}
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                {{ ucfirst($class->level ?? '—') }}
                            </td>
                            <td class="px-4 py-2 text-slate-700 hidden md:table-cell">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs
                                    @if($class->status === 'ongoing') bg-emerald-50 text-emerald-700 border border-emerald-200
                                    @elseif($class->status === 'finished') bg-slate-100 text-slate-700 border border-slate-200
                                    @else bg-sky-50 text-sky-700 border border-sky-200
                                    @endif">
                                    {{ ucfirst($class->status ?? 'planned') }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('course_classes.edit', $class) }}"
                                       class="text-xs px-2 py-1 rounded border border-slate-200 hover:border-skillhub-500 hover:text-skillhub-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('course_classes.destroy', $class) }}" method="POST"
                                          onsubmit="return confirm('Delete this class? This will also remove related enrollments.');">
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
                                No classes yet. Click “New Class” to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($classes, 'links'))
            <div class="border-t border-slate-200 px-4 py-3">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
@endsection
