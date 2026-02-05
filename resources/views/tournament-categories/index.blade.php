@extends('layouts.app')
@section('title', 'Kategori Pertandingan')
@php $header = 'Kategori Pertandingan'; @endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Kelola kategori pertandingan</p>
        <a href="{{ route('tournament-categories.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">+ Tambah Kategori Baru</a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pertandingan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tournamentCategories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->type->value === 'kyourugi' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">{{ ucfirst($category->type->value) }}</span></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->category_type->value === 'festival' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                            {{ $category->category_type->label() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $category->gender->label() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><a href="{{ route('events.show', $category->event) }}" class="text-blue-600 hover:text-blue-800">Event #{{ $category->event_id }}</a></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('tournament-categories.show', $category) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('tournament-categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('tournament-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Kategori tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
