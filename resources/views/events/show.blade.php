<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $event->name ?? 'Pertandingan #' . $event->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <a href="{{ route('events.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm transition">← Kembali ke Pertandingan</a>
                <div class="space-x-2">
                    <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Edit</a>
                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-red-600 transition">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Pertandingan</h2>
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pertandingan</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $event->name }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $event->id }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Durasi</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">🥇 Poin Emas</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $event->gold_point ?? 3 }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">🥈 Poin Perak</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $event->silver_point ?? 2 }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">🥉 Poin Perunggu</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $event->bronze_point ?? 1 }}</dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
