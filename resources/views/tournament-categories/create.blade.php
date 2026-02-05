@extends('layouts.app')
@section('title', 'Tambah Kategori Pertandingan')
@php $header = 'Tambah Kategori Pertandingan Baru'; @endphp

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('tournament-categories.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="space-y-6">
            <div><label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori <span class="text-red-500">*</span></label><input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="event_id" class="block text-sm font-medium text-gray-700">Pertandingan <span class="text-red-500">*</span></label><select name="event_id" id="event_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_id') border-red-500 @enderror" required><option value="">Pilih pertandingan</option>@foreach($events as $event)<option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name ?? 'Pertandingan #' . $event->id }} ({{ $event->start_date->format('d M Y') }})</option>@endforeach</select>@error('event_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div class="grid grid-cols-2 gap-4">
                <div><label for="type" class="block text-sm font-medium text-gray-700">Tipe <span class="text-red-500">*</span></label><select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror" required><option value="">Pilih tipe</option>@foreach($types as $type)<option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>{{ $type->label() }}</option>@endforeach</select>@error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
                <div><label for="gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label><select name="gender" id="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gender') border-red-500 @enderror" required><option value="">Pilih jenis kelamin</option>@foreach($genders as $gender)<option value="{{ $gender->value }}" {{ old('gender') == $gender->value ? 'selected' : '' }}>{{ $gender->label() }}</option>@endforeach</select>@error('gender')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            </div>
            <div>
                <label for="category_type" class="block text-sm font-medium text-gray-700">Jenis Kategori <span class="text-red-500">*</span></label>
                <select name="category_type" id="category_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_type') border-red-500 @enderror" required>
                    <option value="">Pilih jenis kategori</option>
                    @foreach($categoryTypes as $categoryType)
                        <option value="{{ $categoryType->value }}" {{ old('category_type') == $categoryType->value ? 'selected' : '' }}>
                            {{ $categoryType->label() }}
                            @if($categoryType->value === 'festival')
                                (Boleh banyak juara - TIDAK dihitung dalam klasemen)
                            @else
                                (1🥇 1🥈 2🥉 - Dihitung dalam klasemen medali)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('category_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div><label for="age_reference_date" class="block text-sm font-medium text-gray-700">Tanggal Acuan Umur</label><input type="date" name="age_reference_date" id="age_reference_date" value="{{ old('age_reference_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label for="min_age" class="block text-sm font-medium text-gray-700">Umur Min</label><input type="number" name="min_age" id="min_age" value="{{ old('min_age') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
                <div><label for="max_age" class="block text-sm font-medium text-gray-700">Umur Maks</label><input type="number" name="max_age" id="max_age" value="{{ old('max_age') }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></div>
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('tournament-categories.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Tambah Kategori</button>
            </div>
        </div>
    </form>
</div>
@endsection
