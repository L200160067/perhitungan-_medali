@extends('layouts.app')
@section('title', 'Detail Kategori')
@php $header = $tournamentCategory->name; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('tournament-categories.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">← Kembali ke Kategori</a>
        <div class="space-x-2">
            <a href="{{ route('tournament-categories.edit', $tournamentCategory) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Edit</a>
            <form action="{{ route('tournament-categories.destroy', $tournamentCategory) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button></form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kategori</h2>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><dt class="text-sm font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm text-gray-900">{{ $tournamentCategory->id }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Nama</dt><dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $tournamentCategory->name }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Jenis</dt><dd class="mt-1 text-sm text-gray-900">{{ ucfirst($tournamentCategory->type->value) }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Kategori</dt><dd class="mt-1 text-sm text-gray-900">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tournamentCategory->category_type->value === 'festival' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                    {{ $tournamentCategory->category_type->label() }}
                </span>
            </dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt><dd class="mt-1 text-sm text-gray-900">{{ $tournamentCategory->gender->label() }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Pertandingan</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('events.show', $tournamentCategory->event) }}" class="text-blue-600 hover:text-blue-800">{{ $tournamentCategory->event->name ?? 'Pertandingan #' . $tournamentCategory->event_id }}</a></dd></div>
        </dl>
    </div>
</div>
@endsection
