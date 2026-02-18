<x-app-layout title="Edit Kategori">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Kategori Pertandingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('tournament-categories.update', $tournamentCategory) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                @csrf @method('PUT')
                @foreach($queryParams as $key => $value)
                    @if($value)
                        <input type="hidden" name="query_params[{{ $key }}]" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $tournamentCategory->name) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                        @error('name')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="event_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertandingan <span class="text-red-500">*</span></label>
                        <select name="event_id" id="event_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_id') border-red-500 @enderror" required>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id', $tournamentCategory->event_id) == $event->id ? 'selected' : '' }}>{{ $event->name ?? 'Pertandingan #' . $event->id }} ({{ $event->start_date->format('d M Y') }})</option>
                            @endforeach
                        </select>
                        @error('event_id')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe <span class="text-red-500">*</span></label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->value }}" {{ old('type', $tournamentCategory->type->value) == $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>
                                @endforeach
                            </select>
                            @error('type')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror" required>
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->value }}" {{ old('gender', $tournamentCategory->gender->value) == $gender->value ? 'selected' : '' }}>{{ $gender->label() }}</option>
                                @endforeach
                            </select>
                            @error('gender')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="category_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kategori <span class="text-red-500">*</span></label>
                        <select name="category_type" id="category_type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_type') border-red-500 @enderror" required>
                            @foreach($categoryTypes as $categoryType)
                                <option value="{{ $categoryType->value }}" {{ old('category_type', $tournamentCategory->category_type->value) == $categoryType->value ? 'selected' : '' }}>
                                    {{ $categoryType->label() }}
                                    @if($categoryType->value === 'festival')
                                        (Boleh banyak juara - TIDAK dihitung dalam klasemen)
                                    @else
                                        (1🥇 1🥈 2🥉 - Dihitung dalam klasemen medali)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('category_type')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('tournament-categories.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition">Batal</a>
                        <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Perbarui Kategori</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
