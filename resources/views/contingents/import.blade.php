<x-app-layout title="Import Kontingen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Kontingen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Instruksi Import</h3>
                        <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <li>Gunakan file Excel (.xlsx, .xls) atau CSV.</li>
                            <li>Pastikan baris pertama adalah header (nama kolom).</li>
                            <li>Kolom yang wajib ada: <strong>nama_kontingen</strong>, <strong>nama_pertandingan</strong> (nama event), <strong>nama_dojang</strong> (nama dojang).</li>
                            <li>Event harus sudah ada. Dojang akan otomatis dibuat jika belum ada.</li>
                        </ul>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 border-l-4 border-red-500 text-red-700 dark:text-red-200">
                            <h3 class="font-bold">Gagal Import:</h3>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contingents.storeImport') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="file" :value="__('File Excel')" />
                            <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                            <x-input-error class="mt-2" :messages="$errors->get('file')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Import') }}</x-primary-button>
                            <a href="{{ route('contingents.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
