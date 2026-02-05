@extends('layouts.app')

@section('title', 'Dojangs')

@php
    $header = 'Dojangs';
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Manage all dojangs (training centers)</p>
        <a href="{{ route('dojangs.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
            + Add New Dojang
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Contingents</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($dojangs as $dojang)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $dojang->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dojang->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $dojang->participants_count ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">{{ $dojang->contingents_count ?? 0 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('dojangs.show', $dojang) }}" class="text-blue-600 hover:text-blue-900">View</a>
                        <a href="{{ route('dojangs.edit', $dojang) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('dojangs.destroy', $dojang) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this dojang?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <p class="text-lg font-medium">No dojangs found</p>
                            <p class="text-sm mt-1">Get started by creating a new dojang</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($dojangs instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            {{ $dojangs->links() }}
        </div>
    @endif
</div>
@endsection
