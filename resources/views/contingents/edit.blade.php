@extends('layouts.app')
@section('title', 'Edit Kontingen')
@php $header = 'Edit Kontingen'; @endphp

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('contingents.update', $contingent) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kontingen <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $contingent->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="event_id" class="block text-sm font-medium text-gray-700">Pertandingan <span class="text-red-500">*</span></label>
                <select name="event_id" id="event_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_id') border-red-500 @enderror" required>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id', $contingent->event_id) == $event->id ? 'selected' : '' }}>{{ $event->name ?? 'Pertandingan #' . $event->id }} ({{ $event->start_date->format('d M Y') }})</option>
                    @endforeach
                </select>
                @error('event_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="dojang_id" class="block text-sm font-medium text-gray-700">Dojang <span class="text-red-500">*</span></label>
                <select name="dojang_id" id="dojang_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('dojang_id') border-red-500 @enderror" required>
                    @foreach($dojangs as $dojang)
                        <option value="{{ $dojang->id }}" {{ old('dojang_id', $contingent->dojang_id) == $dojang->id ? 'selected' : '' }}>{{ $dojang->name }}</option>
                    @endforeach
                </select>
                @error('dojang_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('contingents.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Batal</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Perbarui Kontingen</button>
            </div>
        </div>
    </form>
</div>
@endsection
