<x-app-layout title="Tambah Peserta">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Peserta Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('participants.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                @csrf
                @foreach($queryParams as $key => $value)
                    @if($value)
                        <input type="hidden" name="query_params[{{ $key }}]" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                            Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                            required>
                        @error('name')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="dojang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dojang
                            <span class="text-red-500">*</span></label>
                        <select name="dojang_id" id="dojang_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dojang_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih dojang</option>
                            @foreach($dojangs as $dojang)
                                <option value="{{ $dojang->id }}" {{ old('dojang_id', request('dojang_id')) == $dojang->id ? 'selected' : '' }}>{{ $dojang->name }}</option>
                            @endforeach
                        </select>
                        @error('dojang_id')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                            Kelamin <span class="text-red-500">*</span></label>
                        <select name="gender" id="gender"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror"
                            required>
                            <option value="">Pilih jenis kelamin</option>
                            @foreach($genders as $gender)
                                <option value="{{ $gender->value }}" {{ old('gender') == $gender->value ? 'selected' : '' }}>
                                    {{ $gender->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('gender')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="birth_date"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror"
                            required>
                        @error('birth_date')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto
                            Peserta</label>
                        <input type="file" name="photo" id="photo" accept="image/jpeg,image/jpg,image/png,image/webp"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG/PNG/WebP, Maks: 5MB. Foto
                            akan otomatis di-crop dan dikompres.</p>
                        @error('photo')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('participants.index') }}"
                            class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition">Batal</a>
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Tambah
                            Peserta</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>