@extends('layouts.app')
@section('title', 'Edit Event')
@php $header = 'Edit Event'; @endphp

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('events.update', $event) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_date') border-red-500 @enderror" required>
                    @error('start_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date <span class="text-red-500">*</span></label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_date') border-red-500 @enderror" required>
                    @error('end_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="gold_point" class="block text-sm font-medium text-gray-700">🥇 Gold Points</label>
                    <input type="number" name="gold_point" id="gold_point" value="{{ old('gold_point', $event->gold_point) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="silver_point" class="block text-sm font-medium text-gray-700">🥈 Silver Points</label>
                    <input type="number" name="silver_point" id="silver_point" value="{{ old('silver_point', $event->silver_point) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="bronze_point" class="block text-sm font-medium text-gray-700">🥉 Bronze Points</label>
                    <input type="number" name="bronze_point" id="bronze_point" value="{{ old('bronze_point', $event->bronze_point) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Update Event</button>
            </div>
        </div>
    </form>
</div>
@endsection
