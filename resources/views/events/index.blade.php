@extends('layouts.app')
@section('title', 'Events')
@php $header = 'Events'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Manage tournament events</p>
        <a href="{{ route('events.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Add New Event</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">End Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">🥇 Gold</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">🥈 Silver</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">🥉 Bronze</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($events as $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $event->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->start_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event->end_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $event->gold_point ?? 3 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $event->silver_point ?? 2 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900">{{ $event->bronze_point ?? 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        <a href="{{ route('events.edit', $event) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No events found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
