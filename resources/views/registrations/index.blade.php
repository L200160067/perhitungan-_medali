@extends('layouts.app')
@section('title', 'Pendaftaran')
@php $header = 'Pendaftaran'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Kelola pendaftaran pertandingan</p>
        <a href="{{ route('registrations.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Tambah Pendaftaran Baru</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontingen</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Medali</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($registrations as $registration)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><a href="{{ route('tournament-categories.show', $registration->category) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->category->name }}</a></td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->category->category_type->color() }}">
                            {{ $registration->category->category_type->label() }}
                        </span>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $registration->participant->name }}</td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900"><a href="{{ route('contingents.show', $registration->contingent) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->contingent->name }}</a></td>
                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->status->color() }}">{{ $registration->status->label() }}</span></td>
                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm">
                        @if($registration->medal)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->medal->color() }}">
                                {{ $registration->medal->label() }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('registrations.show', $registration) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('registrations.edit', $registration) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('registrations.destroy', $registration) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-12 text-center text-gray-500">Pendaftaran tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
