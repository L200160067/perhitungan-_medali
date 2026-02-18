<x-app-layout title="Import Peserta">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import Peserta') }}
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
                            <li>Kolom yang wajib ada: <strong>nama</strong>, <strong>dojang</strong> (nama dojang), <strong>jenis_kelamin</strong> (L/P), <strong>tanggal_lahir</strong>.</li>
                            <li>Kolom opsional: <strong>berat_badan</strong>, <strong>tinggi_badan</strong>.</li>
                            <li>Jika Dojang belum ada, akan otomatis dibuat.</li>
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

                    <form action="{{ route('participants.storeImport') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="file" :value="__('File Excel')" />
                            <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                            <x-input-error class="mt-2" :messages="$errors->get('file')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Import') }}</x-primary-button>
                            <a href="{{ route('participants.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
