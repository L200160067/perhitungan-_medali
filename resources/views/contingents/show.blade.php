@extends('layouts.app')
@section('title', 'Detail Kontingen')
@php $header = $contingent->name; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('contingents.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Kembali ke Kontingen</a>
        <div class="space-x-2">
            <a href="{{ route('contingents.edit', $contingent) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Edit</a>
            <form action="{{ route('contingents.destroy', $contingent) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button></form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kontingen</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><dt class="text-sm font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm text-gray-900">{{ $contingent->id }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Nama</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $contingent->name }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Pertandingan</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('events.show', $contingent->event) }}" class="text-blue-600 hover:text-blue-800">{{ $contingent->event->name ?? 'Pertandingan #' . $contingent->event_id }}</a></dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Dojang</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('dojangs.show', $contingent->dojang) }}" class="text-blue-600 hover:text-blue-800">{{ $contingent->dojang->name }}</a></dd></div>
        </dl>
    </div>
</div>
@endsection
