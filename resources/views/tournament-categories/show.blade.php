@extends('layouts.app')
@section('title', 'Category Details')
@php $header = $tournamentCategory->name; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('tournament-categories.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Back to Categories</a>
        <div class="space-x-2">
            <a href="{{ route('tournament-categories.edit', $tournamentCategory) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Edit</a>
            <form action="{{ route('tournament-categories.destroy', $tournamentCategory) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Delete</button></form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><dt class="text-sm font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm text-gray-900">{{ $tournamentCategory->id }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Name</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $tournamentCategory->name }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Type</dt><dd class="mt-1 text-sm text-gray-900">{{ ucfirst($tournamentCategory->type->value) }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Gender</dt><dd class="mt-1 text-sm text-gray-900">{{ ucfirst($tournamentCategory->gender->value) }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Event</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('events.show', $tournamentCategory->event) }}" class="text-blue-600 hover:text-blue-800">Event #{{ $tournamentCategory->event_id }}</a></dd></div>
        </dl>
    </div>
</div>
@endsection
