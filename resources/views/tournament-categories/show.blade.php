<x-app-layout title="Detail Kategori">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $tournamentCategory->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <a href="{{ route('tournament-categories.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm transition">← Kembali ke Kategori</a>
                <div class="space-x-2">
                    <a href="{{ route('tournament-categories.edit', $tournamentCategory) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Edit</a>
                    <form action="{{ route('tournament-categories.destroy', $tournamentCategory) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-red-600 transition">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Kategori</h2>
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tournamentCategory->id }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $tournamentCategory->name }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Pertandingan</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tournamentCategory->type->label() }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tournamentCategory->category_type->value === 'festival' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                            {{ $tournamentCategory->category_type->label() }}
                        </span>
                    </dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tournamentCategory->gender->label() }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pertandingan</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100"><a href="{{ route('events.show', $tournamentCategory->event) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">{{ $tournamentCategory->event->name ?? 'Pertandingan #' . $tournamentCategory->event_id }}</a></dd></div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
