@extends('layouts.app')

@section('title', 'Edit Participant')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-4">
            <h1 class="text-xl font-semibold text-slate-800">Edit Participant</h1>
            <p class="text-sm text-slate-500">Update participant information.</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
            <form action="{{ route('participants.update', $participant->participant_id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $participant->name) }}" required
                        class="w-full rounded-md border border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $participant->email) }}" required
                            class="w-full rounded-md border border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                        <input type="text" name="phone_number"
                            value="{{ old('phone_number', $participant->phone_number) }}"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('phone_number')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
                    <textarea name="address" rows="2"
                        class="w-full rounded-md border border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">{{ old('address', $participant->address) }}</textarea>
                    @error('address')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Birth Date</label>
                        <input type="date" name="birth_date"
                            value="{{ old('birth_date', $participant->birth_date ? $participant->birth_date->format('Y-m-d') : null) }}"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                        @error('birth_date')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Gender</label>
                        <select name="gender"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 shadow-sm focus:bg-white focus:border-skillhub-500 focus:ring-skillhub-500 text-sm">
                            <option value="">-- Select --</option>
                            <option value="Male" @selected(old('gender', $participant->gender) === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender', $participant->gender) === 'Female')>Female</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('participants.index') }}"
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
