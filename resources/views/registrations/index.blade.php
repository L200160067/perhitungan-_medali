<x-app-layout title="Pendaftaran">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Pilih event untuk memperbarui perolehan medali
                            atlet.</p>
                    </div>

                    @if(session('success'))
                        <div class="fixed top-20 right-4 z-50 w-full max-w-sm overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-lg ring-1 ring-black ring-opacity-5 transition-all duration-300 ease-in-out"
                            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                            <div class="p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Berhasil!</p>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ session('success') }}
                                        </p>
                                    </div>
                                    <div class="ml-4 flex flex-shrink-0">
                                        <button type="button" @click="show = false"
                                            class="inline-flex rounded-md bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <form action="{{ route('registrations.index') }}" method="GET"
                            class="relative flex-1 sm:min-w-[300px]">
                            @if($eventId) <input type="hidden" name="event_id" value="{{ $eventId }}"> @endif
                            @if($perPage != 25) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
                            @if($sort != 'created_at') <input type="hidden" name="sort" value="{{ $sort }}"> @endif
                            @if($direction != 'desc') <input type="hidden" name="direction" value="{{ $direction }}">
                            @endif

                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Cari nama peserta, kontingen, atau kategori..."
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 pl-10 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow hover:shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            @if($search)
                                <a href="{{ route('registrations.index', array_filter(['event_id' => $eventId, 'per_page' => $perPage, 'sort' => $sort, 'direction' => $direction])) }}"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                        @role('admin')
                        <a href="{{ route('registrations.import') }}"
                            class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 transition">Import
                            Excel</a>
                        <a href="{{ route('registrations.create', request()->query()) }}"
                            class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">+
                            Baru</a>
                        @endrole
                    </div>
                </div>

                <!-- Event Selector UI -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('registrations.index') }}"
                        class="relative flex flex-col p-4 rounded-xl border-2 transition-all duration-200 group {{ !$eventId ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-1 ring-blue-500' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span
                                class="text-sm font-bold uppercase tracking-wider {{ !$eventId ? 'text-blue-700 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}">Semua
                                Event</span>
                            @if(!$eventId)
                                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <p
                            class="text-xs {{ !$eventId ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400' }}">
                            Tampilkan semua data pendaftaran</p>
                    </a>

                    @foreach($events as $event)
                        <a href="{{ route('registrations.index', ['event_id' => $event->id]) }}"
                            class="relative flex flex-col p-4 rounded-xl border-2 transition-all duration-200 group {{ $eventId == $event->id ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20 ring-1 ring-blue-500' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-blue-300 dark:hover:border-blue-500 hover:shadow-md' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="text-sm font-bold uppercase tracking-wider {{ $eventId == $event->id ? 'text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }} truncate">{{ $event->name }}</span>
                                @if($eventId == $event->id)
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div
                                class="flex items-center gap-2 text-xs {{ $eventId == $event->id ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-400' }}">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($eventId && ($activeEvent = $events->find($eventId)))
                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 flex flex-col lg:flex-row justify-between items-center gap-6 shadow-sm">
                        <div class="space-y-1 text-center lg:text-left">
                            <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ $activeEvent->name }}</h3>
                            <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Rekap Medali (Kategori Prestasi)
                            </p>
                        </div>
                        <div class="grid grid-cols-3 gap-3">

                            <div
                                class="bg-white dark:bg-gray-800 px-4 py-3 rounded-xl shadow-sm border border-yellow-200 dark:border-yellow-700/50 flex flex-col items-center min-w-[90px] transition-transform hover:scale-105 duration-200">
                                <span
                                    class="text-[10px] font-bold text-yellow-600 dark:text-yellow-400 uppercase tracking-wider mb-1">Emas</span>
                                <span
                                    class="text-2xl font-black text-gray-900 dark:text-white">{{ $medalStats['gold'] }}</span>
                            </div>
                            <div
                                class="bg-white dark:bg-gray-800 px-4 py-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col items-center min-w-[90px] transition-transform hover:scale-105 duration-200">
                                <span
                                    class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Perak</span>
                                <span
                                    class="text-2xl font-black text-gray-900 dark:text-white">{{ $medalStats['silver'] }}</span>
                            </div>
                            <div
                                class="bg-white dark:bg-gray-800 px-4 py-3 rounded-xl shadow-sm border border-orange-200 dark:border-orange-700/50 flex flex-col items-center min-w-[90px] transition-transform hover:scale-105 duration-200">
                                <span
                                    class="text-[10px] font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">Perunggu</span>
                                <span
                                    class="text-2xl font-black text-gray-900 dark:text-white">{{ $medalStats['bronze'] }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden" x-data="{ 
        selected: [],
        count: 0,
        updateCount() {
            this.count = this.selected.length;
            const form = document.getElementById('bulk-delete-form');
            if(form) {
                form.querySelectorAll('input[name=\'ids[]\']').forEach(e => e.remove());
                this.selected.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
            }
        }
    }">
                    @role('admin')
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <form id="bulk-delete-form" action="{{ route('registrations.bulkDestroy') }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                                x-bind:disabled="count === 0">
                                Hapus Terpilih (<span x-text="count"></span>)
                            </button>
                        </form>
                    </div>
                    @endrole
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    @role('admin')
                                    <th class="px-6 py-3 text-left">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                            @change="
                                $el.checked ? 
                                selected = [{{ $registrations->pluck('id')->implode(',') }}] : 
                                selected = [];
                                updateCount();
                            ">
                                    </th>
                                    @endrole
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'id', 'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            No
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'id' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'id')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'category', 'direction' => $sort === 'category' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            Kategori
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'category' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'category')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'type', 'direction' => $sort === 'type' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            Tipe
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'type' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'type')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'participant', 'direction' => $sort === 'participant' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            Peserta
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'participant' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'participant')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'contingent', 'direction' => $sort === 'contingent' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            Kontingen
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'contingent' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'contingent')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            Status
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'status' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'status')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'medal', 'direction' => $sort === 'medal' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}"
                                            class="group inline-flex items-center gap-1">
                                            Medali
                                            <span
                                                class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'medal' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'medal')
                                                    @if($direction === 'asc')
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                @else
                                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </span>
                                        </a>
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($registrations as $registration)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        @role('admin')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                value="{{ $registration->id }}" x-model="selected" @change="updateCount()">
                                        </td>
                                        @endrole
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400 font-medium">
                                            {{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white min-w-[200px]">
                                            <a href="{{ route('tournament-categories.show', $registration->category) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold leading-tight block transition">
                                                {{ $registration->category->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-[10px] leading-4 font-bold rounded-full uppercase tracking-wider {{ $registration->category->category_type->color() }}">
                                                {{ $registration->category->category_type->label() }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium min-w-[150px]">
                                            {{ $registration->participant->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white min-w-[180px]">
                                            <a href="{{ route('contingents.show', $registration->contingent) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 leading-tight block transition">
                                                {{ $registration->contingent->name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->status->color() }}">
                                                {{ $registration->status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            @if($registration->medal)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->medal->color() }}">
                                                    {{ $registration->medal->label() }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-600">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('registrations.show', $registration) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition">Lihat</a>
                                            <a href="{{ route('registrations.edit', ['registration' => $registration] + request()->query()) }}"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition">Edit</a>
                                            @role('admin')
                                            <form action="{{ route('registrations.destroy', $registration) }}" method="POST"
                                                class="inline" onsubmit="return confirm('Apakah Anda yakin?');">
                                                @csrf @method('DELETE')
                                                @foreach(request()->only(['event_id', 'search', 'page', 'sort', 'direction', 'per_page']) as $key => $value)
                                                    @if($value) <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                    @endif
                                                @endforeach
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition">Hapus</button>
                                            </form>
                                            @endrole
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                            Pendaftaran tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($registrations->hasPages() || $registrations->total() > 25)
                    <div
                        class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden text-gray-900 dark:text-gray-100">
                            {{ $registrations->links('pagination::simple-tailwind') }}
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    Menampilkan
                                    <span
                                        class="font-medium dark:text-gray-200">{{ $registrations->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span
                                        class="font-medium dark:text-gray-200">{{ $registrations->lastItem() ?? 0 }}</span>
                                    dari
                                    <span class="font-medium dark:text-gray-200">{{ $registrations->total() }}</span>
                                    data
                                </p>
                                <div class="flex items-center gap-2">
                                    <label for="per_page" class="text-sm text-gray-500 dark:text-gray-400">Baris:</label>
                                    <select id="per_page" onchange="window.location.href = this.value"
                                        class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 py-1 pl-2 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 transition">
                                        @foreach([25, 50, 100] as $size)
                                            <option
                                                value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="dark:text-gray-100">
                                {{ $registrations->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
</x-app-layout>