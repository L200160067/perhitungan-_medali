@extends('layouts.app')
@section('title', 'Edit Tournament Category')
@php $header = 'Edit Tournament Category'; @endphp

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('tournament-categories.update', $tournamentCategory) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-6">
            <div><label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label><input type="text" name="name" id="name" value="{{ old('name', $tournamentCategory->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="event_id" class="block text-sm font-medium text-gray-700">Event <span class="text-red-500">*</span></label><select name="event_id" id="event_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_id') border-red-500 @enderror" required>@foreach($events as $event)<option value="{{ $event->id }}" {{ old('event_id', $tournamentCategory->event_id) == $event->id ? 'selected' : '' }}>Event #{{ $event->id }} ({{ $event->start_date->format('M d, Y') }})</option>@endforeach</select>@error('event_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="grid grid-cols-2 gap-4">
                <div><label for="type" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label><select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror" required>@foreach($types as $type)<option value="{{ $type->value }}" {{ old('type', $tournamentCategory->type->value) == $type->value ? 'selected' : '' }}>{{ ucfirst($type->value) }}</option>@endforeach</select>@error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                <div><label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label><select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror" required>@foreach($genders as $gender)<option value="{{ $gender->value }}" {{ old('gender', $tournamentCategory->gender->value) == $gender->value ? 'selected' : '' }}>{{ ucfirst($gender->value) }}</option>@endforeach</select>@error('gender')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('tournament-categories.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Update Category</button>
            </div>
        </div>
    </form>
</div>
@endsection
