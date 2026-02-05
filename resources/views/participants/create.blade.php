@extends('layouts.app')

@section('title', 'Create Participant')

@php
    $header = 'Create New Participant';
@endphp

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('participants.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="dojang_id" class="block text-sm font-medium text-gray-700">Dojang <span class="text-red-500">*</span></label>
                <select 
                    name="dojang_id" 
                    id="dojang_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dojang_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Select a dojang</option>
                    @foreach($dojangs as $dojang)
                        <option value="{{ $dojang->id }}" {{ old('dojang_id', request('dojang_id')) == $dojang->id ? 'selected' : '' }}>
                            {{ $dojang->name }}
                        </option>
                    @endforeach
                </select>
                @error('dojang_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                <select 
                    name="gender" 
                    id="gender" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror"
                    required
                >
                    <option value="">Select gender</option>
                    @foreach($genders as $gender)
                        <option value="{{ $gender->value }}" {{ old('gender') == $gender->value ? 'selected' : '' }}>
                            {{ $gender->value === 'M' ? 'Male' : 'Female' }}
                        </option>
                    @endforeach
                </select>
                @error('gender')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date <span class="text-red-500">*</span></label>
                <input 
                    type="date" 
                    name="birth_date" 
                    id="birth_date" 
                    value="{{ old('birth_date') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror"
                    required
                >
                @error('birth_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('participants.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                    Create Participant
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
