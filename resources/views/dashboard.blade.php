@extends('layouts.app')

@section('title', 'Dashboard')

@php
    $header = 'Dashboard';
@endphp

@section('content')
<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Events -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-blue-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-gray-500">Total Events</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $totalEvents }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <a href="{{ route('events.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">View all →</a>
            </div>
        </div>

        <!-- Total Dojangs -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-green-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-gray-500">Total Dojangs</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $totalDojangs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <a href="{{ route('dojangs.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500">View all →</a>
            </div>
        </div>

        <!-- Total Participants -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-purple-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-gray-500">Total Participants</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $totalParticipants }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <a href="{{ route('participants.index') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">View all →</a>
            </div>
        </div>

        <!-- Total Registrations -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="rounded-md bg-orange-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="truncate text-sm font-medium text-gray-500">Total Registrations</dt>
                            <dd class="text-3xl font-semibold text-gray-900">{{ $totalRegistrations }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <a href="{{ route('registrations.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-500">View all →</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="rounded-lg bg-white shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
                + New Event
            </a>
            <a href="{{ route('dojangs.create') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-500 transition">
                + New Dojang
            </a>
            <a href="{{ route('participants.create') }}" class="inline-flex items-center justify-center rounded-md bg-purple-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 transition">
                + New Participant
            </a>
            <a href="{{ route('registrations.create') }}" class="inline-flex items-center justify-center rounded-md bg-orange-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 transition">
                + New Registration
            </a>
        </div>
    </div>

    <!-- Medal Standings (if there are events) -->
    @if($medalStandings->isNotEmpty())
    <div class="rounded-lg bg-white shadow">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">🏆 Medal Standings</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contingent</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">🥇 Gold</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">🥈 Silver</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">🥉 Bronze</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($medalStandings as $index => $standing)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $standing->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-semibold">{{ $standing->gold_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-semibold">{{ $standing->silver_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-semibold">{{ $standing->bronze_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 font-bold">{{ $standing->total_medals }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
