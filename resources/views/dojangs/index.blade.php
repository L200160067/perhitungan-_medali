<x-app-layout title="Dojang">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dojang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400">Kelola semua dojang (pusat pelatihan)</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <form action="{{ route('dojangs.index') }}" method="GET" class="relative flex-1 sm:min-w-[300px]">
                            @if($perPage != 25) <input type="hidden" name="per_page" value="{{ $perPage }}"> @endif
                            @if($sort != 'name') <input type="hidden" name="sort" value="{{ $sort }}"> @endif
                            @if($direction != 'asc') <input type="hidden" name="direction" value="{{ $direction }}"> @endif
                            
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama dojang..." 
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 pl-10 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow hover:shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            @if($search)
                                <a href="{{ route('dojangs.index', array_filter(['per_page' => $perPage, 'sort' => $sort, 'direction' => $direction])) }}" 
                                   class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                        </form>
                        @role('admin')
                        <a href="{{ route('dojangs.import') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 transition">
                            Import Excel
                        </a>
                        <a href="{{ route('dojangs.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
                            + Baru
                        </a>
                        @endrole
                    </div>
                </div>

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
                        <form id="bulk-delete-form" action="{{ route('dojangs.bulkDestroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed" 
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
                                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                            @change="
                                                $el.checked ? 
                                                selected = [{{ $dojangs->pluck('id')->implode(',') }}] : 
                                                selected = [];
                                                updateCount();
                                            ">
                                    </th>
                                    @endrole
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-nowrap">
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
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-nowrap">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'participants_count', 'direction' => $sort === 'participants_count' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                                            Peserta
                                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'participants_count' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'participants_count')
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
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider text-nowrap">
                                        <a href="{{ request()->fullUrlWithQuery(['search' => $search, 'sort' => 'contingents_count', 'direction' => $sort === 'contingents_count' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                                            Kontingen
                                            <span class="flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'contingents_count' ? 'visible' : 'invisible group-hover:visible' }}">
                                                @if($sort === 'contingents_count')
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
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($dojangs as $dojang)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    @role('admin')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                            value="{{ $dojang->id }}" x-model="selected" @change="updateCount()">
                                    </td>
                                    @endrole
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $dojang->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-gray-300">{{ $dojang->participants_count ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-gray-300">{{ $dojang->contingents_count ?? 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('dojangs.show', $dojang) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">Lihat</a>
                                        <a href="{{ route('dojangs.edit', $dojang) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">Edit</a>
                                        @role('admin')
                                        <form action="{{ route('dojangs.destroy', $dojang) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dojang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition">Hapus</button>
                                        </form>
                                        @endrole
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg class="h-12 w-12 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-lg font-medium">Dojang tidak ditemukan</p>
                                            <p class="text-sm mt-1">Mulailah dengan membuat dojang baru</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($dojangs->hasPages() || $dojangs->total() > 25)
                    <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden text-gray-900 dark:text-gray-100">
                            {{ $dojangs->links('pagination::simple-tailwind') }}
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div class="flex items-center gap-4">
                                <p class="text-sm text-gray-700 dark:text-gray-400">
                                    Menampilkan
                                    <span class="font-medium dark:text-gray-200">{{ $dojangs->firstItem() ?? 0 }}</span>
                                    sampai
                                    <span class="font-medium dark:text-gray-200">{{ $dojangs->lastItem() ?? 0 }}</span>
                                    dari
                                    <span class="font-medium dark:text-gray-200">{{ $dojangs->total() }}</span>
                                    data
                                </p>
                                <div class="flex items-center gap-2">
                                    <label for="per_page" class="text-sm text-gray-500 dark:text-gray-400">Baris:</label>
                                    <select id="per_page" onchange="window.location.href = this.value" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 py-1 pl-2 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 transition">
                                        @foreach([25, 50, 100] as $size)
                                            <option value="{{ request()->fullUrlWithQuery(['search' => $search, 'per_page' => $size, 'page' => 1]) }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="dark:text-gray-100">
                                {{ $dojangs->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
