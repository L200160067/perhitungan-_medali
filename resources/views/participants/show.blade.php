@extends('layouts.app')

@section('title', 'Participant Details')

@php
    $header = $participant->name;
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('participants.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Back to Participants</a>
        <div class="space-x-2">
            <a href="{{ route('participants.edit', $participant) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                Edit
            </a>
            <form action="{{ route('participants.destroy', $participant) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Participant Information</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $participant->id }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $participant->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Dojang</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <a href="{{ route('dojangs.show', $participant->dojang) }}" class="text-blue-600 hover:text-blue-800">{{ $participant->dojang->name }}</a>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Gender</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $participant->gender->value === 'M' ? 'Male' : 'Female' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Birth Date</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $participant->birth_date->format('M d, Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Age</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $participant->birth_date->age }} years old</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
