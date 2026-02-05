@extends('layouts.app')
@section('title', 'Registrations')
@php $header = 'Registrations'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Manage competition registrations</p>
        <a href="{{ route('registrations.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Add New Registration</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contingent</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Medal</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($registrations as $registration)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $registration->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><a href="{{ route('tournament-categories.show', $registration->category) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->category->name }}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><a href="{{ route('contingents.show', $registration->contingent) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->contingent->name }}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_', ' ', $registration->status->value)) }}</span></td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">{{ $registration->medal ? ucfirst($registration->medal->name) : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('registrations.show', $registration) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        <a href="{{ route('registrations.edit', $registration) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('registrations.destroy', $registration) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No registrations found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
