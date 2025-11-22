@extends('layouts.app')

@section('title', 'Enrollment Detail')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-xl font-semibold text-slate-800">Enrollment Detail</h1>
                    <p class="text-sm text-slate-500">Participant enrolled in a class.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('participant_classes.edit', $participantClass) }}"
                       class="text-xs px-3 py-2 rounded-md border border-slate-200 hover:border-skillhub-500 hover:text-skillhub-600">
                        Edit
                    </a>
                    <a href="{{ route('participant_classes.index') }}"
                       class="text-xs px-3 py-2 rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50">
                        Back
                    </a>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6 text-sm">
                <div>
                    <h2 class="font-semibold text-slate-800 mb-2">Participant</h2>
                    <dl class="space-y-2">
                        <div>
                            <dt class="font-medium text-slate-700">Name</dt>
                            <dd class="text-slate-600">
                                @if($participantClass->participant)
                                    <a href="{{ route('participants.show', $participantClass->participant) }}"
                                       class="hover:text-skillhub-600">
                                        {{ $participantClass->participant->name }}
                                    </a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-700">Email</dt>
                            <dd class="text-slate-600">
                                {{ $participantClass->participant->email ?? '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h2 class="font-semibold text-slate-800 mb-2">Class</h2>
                    <dl class="space-y-2">
                        <div>
                            <dt class="font-medium text-slate-700">Title</dt>
                            <dd class="text-slate-600">
                                @if($participantClass->class)
                                    <a href="{{ route('course_classes.show', $participantClass->class) }}"
                                       class="hover:text-skillhub-600">
                                        {{ $participantClass->class->title }}
                                    </a>
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-slate-700">Category</dt>
                            <dd class="text-slate-600">
                                {{ $participantClass->class->category ?? '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-6 border-t border-slate-100 pt-4 grid md:grid-cols-4 gap-4 text-sm">
                <div>
                    <dt class="font-medium text-slate-700">Enrolled At</dt>
                    <dd class="text-slate-600">
                        {{ $participantClass->enrolled_at ? \Carbon\Carbon::parse($participantClass->enrolled_at)->format('d M Y') : '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-700">Status</dt>
                    <dd class="text-slate-600">{{ ucfirst($participantClass->status) }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-700">Progress</dt>
                    <dd class="text-slate-600">{{ $participantClass->progress }}%</dd>
                </div>
                <div>
                    <dt class="font-medium text-slate-700">Grade</dt>
                    <dd class="text-slate-600">{{ $participantClass->grade ?? '—' }}</dd>
                </div>
            </div>
        </div>
    </div>
@endsection
