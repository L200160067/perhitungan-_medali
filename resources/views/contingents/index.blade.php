@extends('layouts.app')
@section('title', 'Kontingen')
@php $header = 'Kontingen'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <p class="text-gray-600">Kelola kontingen</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form action="{{ route('contingents.index') }}" method="GET" class="relative flex-1 sm:min-w-[300px]">
                @if($perPage != 25) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
                @if($sort != 'name') <input type="hidden" name="sort" value="{{ $sort }}"> @endif
                @if($direction != 'asc') <input type="hidden" name="direction" value="{{ $direction }}"> @endif
                
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama kontingen, pertandingan, atau dojang..." 
                    class="w-full rounded-md border-gray-300 pl-10 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow hover:shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                @if($search)
                    <a href="{{ route('contingents.index', array_filter(['per_page' => $perPage, 'sort' => $sort, 'direction' => $direction])) }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    </a>
                @endif
            </form>
            <a href="{{ route('contingents.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Baru</a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Nama
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'name' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'name')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'event', 'direction' => $sort === 'event' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Pertandingan
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'event' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'event')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'dojang', 'direction' => $sort === 'dojang' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Dojang
                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'dojang' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'dojang')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contingents as $contingent)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900 min-w-[180px]">{{ $contingent->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 min-w-[220px]"><a href="{{ route('events.show', $contingent->event) }}" class="text-blue-600 hover:text-blue-800 leading-tight block">{{ $contingent->event->name ?? 'Pertandingan #' . $contingent->event_id }}</a></td>
                    <td class="px-6 py-4 text-sm text-gray-600 min-w-[200px]"><a href="{{ route('dojangs.show', $contingent->dojang) }}" class="text-blue-600 hover:text-blue-800 leading-tight block">{{ $contingent->dojang->name }}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('contingents.show', $contingent) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('contingents.edit', $contingent) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('contingents.destroy', $contingent) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Kontingen tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>

        @if($contingents->hasPages() || $contingents->total() > 25)
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $contingents->links('pagination::simple-tailwind') }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <p class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-medium">{{ $contingents->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $contingents->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $contingents->total() }}</span>
                        data
                    </p>
                    <div class="flex items-center gap-2">
                        <label for="per_page" class="text-sm text-gray-500">Baris:</label>
                        <select id="per_page" onchange="window.location.href = this.value" class="rounded-md border-gray-300 py-1 pl-2 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            @foreach([25, 50, 100] as $size)
                                <option value="{{ request()->fullUrlWithQuery(['search' => $search, 'per_page' => $size, 'page' => 1]) }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    {{ $contingents->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
