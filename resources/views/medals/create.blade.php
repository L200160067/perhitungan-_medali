@extends('layouts.app')
@section('title', 'Create Medal')
@php $header = 'Create New Medal'; @endphp

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('medals.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="space-y-6">
            <div><label for="name" class="block text-sm font-medium text-gray-700">Medal Name <span class="text-red-500">*</span></label><input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="rank" class="block text-sm font-medium text-gray-700">Rank <span class="text-red-500">*</span></label><input type="number" name="rank" id="rank" value="{{ old('rank', 1) }}" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('rank') border-red-500 @enderror" required>@error('rank')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('medals.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Create Medal</button>
            </div>
        </div>
    </form>
</div>
@endsection
