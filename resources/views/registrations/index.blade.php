@extends('layouts.app')
@section('title', 'Pendaftaran')
@php $header = 'Pendaftaran'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <p class="text-gray-600">Pilih event untuk memperbarui perolehan medali atlet.</p>
        </div>
        <a href="{{ route('registrations.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-colors duration-200">+ Tambah Pendaftaran Baru</a>
    </div>

    <!-- Event Selector UI -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('registrations.index') }}" 
           class="relative flex flex-col p-4 rounded-xl border-2 transition-all duration-200 group {{ !$eventId ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200 bg-white hover:border-blue-300 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-bold uppercase tracking-wider {{ !$eventId ? 'text-blue-700' : 'text-gray-500 group-hover:text-blue-600' }}">Semua Event</span>
                @if(!$eventId)
                    <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                @endif
            </div>
            <p class="text-xs {{ !$eventId ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}">Tampilkan semua data pendaftaran</p>
        </a>

        @foreach($events as $event)
            <a href="{{ route('registrations.index', ['event_id' => $event->id]) }}" 
               class="relative flex flex-col p-4 rounded-xl border-2 transition-all duration-200 group {{ $eventId == $event->id ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-gray-200 bg-white hover:border-blue-300 hover:shadow-md' }}">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold uppercase tracking-wider {{ $eventId == $event->id ? 'text-blue-700' : 'text-gray-600 group-hover:text-blue-600' }} truncate">{{ $event->name }}</span>
                    @if($eventId == $event->id)
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    @endif
                </div>
                <div class="flex items-center gap-2 text-xs {{ $eventId == $event->id ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    {{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}
                </div>
            </a>
        @endforeach
    </div>

    @if($eventId && ($activeEvent = $events->find($eventId)))
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 flex flex-col lg:flex-row justify-between items-center gap-6 shadow-sm">
            <div class="space-y-1 text-center lg:text-left">
                <h3 class="text-lg font-bold text-blue-900">{{ $activeEvent->name }}</h3>
                <p class="text-sm text-blue-700 font-medium">Rekap Medali (Kategori Prestasi)</p>
            </div>
            <div class="grid grid-cols-3 gap-3">
                @php
                    $registrationsForSummary = $registrations->where('category.category_type', \App\Enums\CategoryType::Prestasi);
                    $gold = $registrationsForSummary->where('medal.name', 'gold')->count();
                    $silver = $registrationsForSummary->where('medal.name', 'silver')->count();
                    $bronze = $registrationsForSummary->where('medal.name', 'bronze')->count();
                @endphp
                <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-yellow-200 flex flex-col items-center min-w-[90px] transition-transform hover:scale-105 duration-200">
                    <span class="text-[10px] font-bold text-yellow-600 uppercase tracking-wider mb-1">Emas</span>
                    <span class="text-2xl font-black text-gray-900">{{ $gold }}</span>
                </div>
                <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-200 flex flex-col items-center min-w-[90px] transition-transform hover:scale-105 duration-200">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Perak</span>
                    <span class="text-2xl font-black text-gray-900">{{ $silver }}</span>
                </div>
                <div class="bg-white px-4 py-3 rounded-xl shadow-sm border border-orange-200 flex flex-col items-center min-w-[90px] transition-transform hover:scale-105 duration-200">
                    <span class="text-[10px] font-bold text-orange-600 uppercase tracking-wider mb-1">Perunggu</span>
                    <span class="text-2xl font-black text-gray-900">{{ $bronze }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            No
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'id' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'id')
                                    @if($direction === 'asc')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-3 w-3 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'category', 'direction' => $sort === 'category' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Kategori
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'category' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'category')
                                    @if($direction === 'asc')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-3 w-3 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'participant', 'direction' => $sort === 'participant' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Peserta
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'participant' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'participant')
                                    @if($direction === 'asc')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-3 w-3 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'contingent', 'direction' => $sort === 'contingent' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Kontingen
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'contingent' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'contingent')
                                    @if($direction === 'asc')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-3 w-3 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Status
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'status' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'status')
                                    @if($direction === 'asc')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-3 w-3 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'medal', 'direction' => $sort === 'medal' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Medali
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'medal' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'medal')
                                    @if($direction === 'asc')
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-3 w-3 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($registrations as $registration)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-500 font-medium">{{ $loop->iteration }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900 min-w-[200px]">
                        <a href="{{ route('tournament-categories.show', $registration->category) }}" class="text-blue-600 hover:text-blue-800 font-semibold leading-tight block">{{ $registration->category->name }}</a>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="px-2.5 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-full uppercase tracking-wider {{ $registration->category->category_type->color() }}">
                            {{ $registration->category->category_type->label() }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-sm text-gray-900 font-medium min-w-[150px]">{{ $registration->participant->name }}</td>
                    <td class="px-4 py-4 text-sm text-gray-900 min-w-[180px]">
                        <a href="{{ route('contingents.show', $registration->contingent) }}" class="text-blue-600 hover:text-blue-800 leading-tight block">{{ $registration->contingent->name }}</a>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->status->color() }}">{{ $registration->status->label() }}</span></td>
                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                        @if($registration->medal)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->medal->color() }}">
                                {{ $registration->medal->label() }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('registrations.show', $registration) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('registrations.edit', $registration) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('registrations.destroy', $registration) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-12 text-center text-gray-500">Pendaftaran tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($registrations->hasPages() || $registrations->total() > 25)
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-b-lg shadow-sm">
        <div class="flex-1 flex justify-between sm:hidden">
            {{ $registrations->links('pagination::simple-tailwind') }}
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <p class="text-sm text-gray-700">
                    Menampilkan
                    <span class="font-medium">{{ $registrations->firstItem() ?? 0 }}</span>
                    sampai
                    <span class="font-medium">{{ $registrations->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-medium">{{ $registrations->total() }}</span>
                    data
                </p>
                <div class="flex items-center gap-2">
                    <label for="per_page" class="text-sm text-gray-500">Baris:</label>
                    <select id="per_page" onchange="window.location.href = this.value" class="rounded-md border-gray-300 py-1 pl-2 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                        @foreach([25, 50, 100] as $size)
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                {{ $registrations->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
