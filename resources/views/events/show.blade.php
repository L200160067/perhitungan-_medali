@extends('layouts.app')
@section('title', 'Detail Pertandingan')
@php $header = $event->name ?? 'Pertandingan #' . $event->id; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Kembali ke Pertandingan</a>
        <div class="space-x-2">
            <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Edit</a>
            <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pertandingan</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><dt class="text-sm font-medium text-gray-500">Nama Pertandingan</dt><dd class="mt-1 text-sm text-gray-900 font-medium">{{ $event->name }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm text-gray-900">{{ $event->id }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Durasi</dt><dd class="mt-1 text-sm text-gray-900">{{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">🥇 Poin Emas</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $event->gold_point ?? 3 }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">🥈 Poin Perak</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $event->silver_point ?? 2 }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">🥉 Poin Perunggu</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $event->bronze_point ?? 1 }}</dd></div>
        </dl>
    </div>
</div>
@endsection
