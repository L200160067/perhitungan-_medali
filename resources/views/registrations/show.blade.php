@extends('layouts.app')
@section('title', 'Registration Details')
@php $header = 'Registration #' . $registration->id; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('registrations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Back to Registrations</a>
        <div class="space-x-2">
            <a href="{{ route('registrations.edit', $registration) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Edit</a>
            <form action="{{ route('registrations.destroy', $registration) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Delete</button></form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Registration Information</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><dt class="text-sm font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm text-gray-900">{{ $registration->id }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Category</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('tournament-categories.show', $registration->category) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->category->name }}</a></dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Participant</dt><dd class="mt-1 text-sm text-gray-900">{{ $registration->participant->name }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Contingent</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('contingents.show', $registration->contingent) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->contingent->name }}</a></dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Status</dt><dd class="mt-1 text-sm text-gray-900"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->status->color() }}">{{ ucfirst(str_replace('_', ' ', $registration->status->value)) }}</span></dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Medal</dt><dd class="mt-1 text-sm text-gray-900">{{ $registration->medal ? ucfirst($registration->medal->name) : 'No medal' }}</dd></div>
        </dl>
    </div>
</div>
@endsection
