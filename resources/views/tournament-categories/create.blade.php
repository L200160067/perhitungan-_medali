@extends('layouts.app')
@section('title', 'Create Tournament Category')
@php $header = 'Create New Tournament Category'; @endphp

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('tournament-categories.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="space-y-6">
            <div><label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label><input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="event_id" class="block text-sm font-medium text-gray-700">Event <span class="text-red-500">*</span></label><select name="event_id" id="event_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_id') border-red-500 @enderror" required><option value="">Select an event</option>@foreach($events as $event)<option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>Event #{{ $event->id }} ({{ $event->start_date->format('M d, Y') }})</option>@endforeach</select>@error('event_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="grid grid-cols-2 gap-4">
                <div><label for="type" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label><select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror" required><option value="">Select type</option>@foreach($types as $type)<option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>{{ ucfirst($type->value) }}</option>@endforeach</select>@error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                <div><label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label><select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror" required><option value="">Select gender</option>@foreach($genders as $gender)<option value="{{ $gender->value }}" {{ old('gender') == $gender->value ? 'selected' : '' }}>{{ ucfirst($gender->value) }}</option>@endforeach</select>@error('gender')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            </div>
            <div><label for="age_reference_date" class="block text-sm font-medium text-gray-700">Age Reference Date</label><input type="date" name="age_reference_date" id="age_reference_date" value="{{ old('age_reference_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label for="min_age" class="block text-sm font-medium text-gray-700">Min Age</label><input type="number" name="min_age" id="min_age" value="{{ old('min_age') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
                <div><label for="max_age" class="block text-sm font-medium text-gray-700">Max Age</label><input type="number" name="max_age" id="max_age" value="{{ old('max_age') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('tournament-categories.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Create Category</button>
            </div>
        </div>
    </form>
</div>
@endsection
