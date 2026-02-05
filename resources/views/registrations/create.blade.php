<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pendaftaran Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('registrations.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Pertandingan <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories->groupBy('event_id') as $eventId => $eventCategories)
                                <optgroup label="Pertandingan: {{ $eventCategories->first()->event->name ?? '#' . $eventId }}">
                                    @foreach($eventCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="participant_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Peserta <span class="text-red-500">*</span></label>
                        <select name="participant_id" id="participant_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('participant_id') border-red-500 @enderror" required>
                            <option value="">Pilih peserta</option>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->id }}" {{ old('participant_id') == $participant->id ? 'selected' : '' }}>{{ $participant->name }}</option>
                            @endforeach
                        </select>
                        @error('participant_id')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="contingent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontingen <span class="text-red-500">*</span></label>
                        <select name="contingent_id" id="contingent_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('contingent_id') border-red-500 @enderror" required>
                            <option value="">Pilih kontingen</option>
                            @foreach($contingents->groupBy('event_id') as $eventId => $eventContingents)
                                <optgroup label="Pertandingan: {{ $eventContingents->first()->event->name ?? '#' . $eventId }}">
                                    @foreach($eventContingents as $contingent)
                                        <option value="{{ $contingent->id }}" {{ old('contingent_id') == $contingent->id ? 'selected' : '' }}>{{ $contingent->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('contingent_id')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="medal_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Medali</label>
                        <select name="medal_id" id="medal_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('medal_id') border-red-500 @enderror">
                            <option value="">Tidak ada medali</option>
                            @foreach($medals as $medal)
                                <option value="{{ $medal->id }}" {{ old('medal_id') == $medal->id ? 'selected' : '' }}>{{ $medal->label() }}</option>
                            @endforeach
                        </select>
                        @error('medal_id')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('registrations.index') }}" class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition">Batal</a>
                        <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Simpan Pendaftaran</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
