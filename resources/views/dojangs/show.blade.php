@extends('layouts.app')

@section('title', 'Dojang Details')

@php
    $header = $dojang->name;
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <a href="{{ route('dojangs.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Back to Dojangs</a>
        </div>
        <div class="space-x-2">
            <a href="{{ route('dojangs.edit', $dojang) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                Edit
            </a>
            <form action="{{ route('dojangs.destroy', $dojang) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this dojang?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Dojang Info -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Dojang Information</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $dojang->id }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $dojang->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $dojang->created_at->format('M d, Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $dojang->updated_at->format('M d, Y H:i') }}</dd>
            </div>
        </dl>
    </div>

    <!-- Participants -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Participants ({{ $dojang->participants->count() }})</h2>
            <a href="{{ route('participants.create', ['dojang_id' => $dojang->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">+ Add Participant</a>
        </div>
        @if($dojang->participants->isNotEmpty())
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gender</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Birth Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dojang->participants as $participant)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <a href="{{ route('participants.show', $participant) }}" class="text-blue-600 hover:text-blue-800">{{ $participant->name }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $participant->gender->value }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $participant->birth_date->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="px-6 py-12 text-center text-gray-500">
            <p>No participants yet</p>
        </div>
        @endif
    </div>

    <!-- Contingents -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Contingents ({{ $dojang->contingents->count() }})</h2>
        </div>
        @if($dojang->contingents->isNotEmpty())
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($dojang->contingents as $contingent)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        <a href="{{ route('contingents.show', $contingent) }}" class="text-blue-600 hover:text-blue-800">{{ $contingent->name }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <a href="{{ route('events.show', $contingent->event) }}" class="text-blue-600 hover:text-blue-800">Event #{{ $contingent->event_id }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="px-6 py-12 text-center text-gray-500">
            <p>No contingents yet</p>
        </div>
        @endif
    </div>
</div>
@endsection
