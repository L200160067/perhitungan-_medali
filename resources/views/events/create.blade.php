<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pertandingan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('events.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                @csrf
                @foreach($queryParams as $key => $value)
                    @if($value)
                        <input type="hidden" name="query_params[{{ $key }}]" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pertandingan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="Contoh: Piala Menpora 2026" required autofocus>
                        @error('name')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('start_date') border-red-500 @enderror" required>
                            @error('start_date')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('end_date') border-red-500 @enderror" required>
                            @error('end_date')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="gold_point" class="block text-sm font-medium text-gray-700 dark:text-gray-300">🥇 Poin Emas</label>
                            <input type="number" name="gold_point" id="gold_point" value="{{ old('gold_point', 3) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="silver_point" class="block text-sm font-medium text-gray-700 dark:text-gray-300">🥈 Poin Perak</label>
                            <input type="number" name="silver_point" id="silver_point" value="{{ old('silver_point', 2) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="bronze_point" class="block text-sm font-medium text-gray-700 dark:text-gray-300">🥉 Poin Perunggu</label>
                            <input type="number" name="bronze_point" id="bronze_point" value="{{ old('bronze_point', 1) }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        </div>
                    </div>

                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input id="count_festival_medals" aria-describedby="count_festival_medals-description" name="count_festival_medals" type="checkbox" value="1" {{ old('count_festival_medals') ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-600 dark:bg-gray-900">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="count_festival_medals" class="font-medium text-gray-900 dark:text-gray-100">Hitung Medali Festival?</label>
                            <p id="count_festival_medals-description" class="text-gray-500 dark:text-gray-400">Jika diaktifkan, medali dari kategori Festival akan ikut dihitung dalam klasemen "Kategori Prestasi".</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition">Batal</a>
                        <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Tambah Pertandingan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
