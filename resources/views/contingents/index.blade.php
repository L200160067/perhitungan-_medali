@extends('layouts.app')
@section('title', 'Kontingen')
@php $header = 'Kontingen'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Kelola kontingen</p>
        <a href="{{ route('contingents.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Tambah Kontingen Baru</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pertandingan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dojang</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contingents as $contingent)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $contingent->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $contingent->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><a href="{{ route('events.show', $contingent->event) }}" class="text-blue-600 hover:text-blue-800">Event #{{ $contingent->event_id }}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><a href="{{ route('dojangs.show', $contingent->dojang) }}" class="text-blue-600 hover:text-blue-800">{{ $contingent->dojang->name }}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('contingents.show', $contingent) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('contingents.edit', $contingent) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('contingents.destroy', $contingent) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Kontingen tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
