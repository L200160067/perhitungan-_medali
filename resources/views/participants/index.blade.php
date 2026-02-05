@extends('layouts.app')

@section('title', 'Peserta')

@php
    $header = 'Peserta';
@endphp

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Kelola semua peserta</p>
        <a href="{{ route('participants.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition">
            + Tambah Peserta Baru
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Nama
                            <span class="ml-2 flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'name' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'name')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'dojang', 'direction' => $sort === 'dojang' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Dojang
                            <span class="ml-2 flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'dojang' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'dojang')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'gender', 'direction' => $sort === 'gender' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Jenis Kelamin
                            <span class="ml-2 flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'gender' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'gender')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-nowrap">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'birth_date', 'direction' => $sort === 'birth_date' && $direction === 'asc' ? 'desc' : 'asc', 'page' => 1]) }}" class="group inline-flex items-center gap-1">
                            Tanggal Lahir
                            <span class="ml-2 flex-none rounded text-gray-400 group-hover:visible {{ $sort === 'birth_date' ? 'visible' : 'invisible group-hover:visible' }}">
                                @if($sort === 'birth_date')
                                    @if($direction === 'asc')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>
                                    @else
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    @endif
                                @else
                                    <svg class="h-4 w-4 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                @endif
                            </span>
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($participants as $participant)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-900 min-w-[180px]">{{ $participant->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 min-w-[200px]">
                        <a href="{{ route('dojangs.show', $participant->dojang) }}" class="text-blue-600 hover:text-blue-800 leading-tight block">{{ $participant->dojang->name }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $participant->gender->value === 'M' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $participant->gender->label() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $participant->birth_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        <a href="{{ route('participants.show', $participant) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                        <a href="{{ route('participants.edit', $participant) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        <form action="{{ route('participants.destroy', $participant) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <p class="text-lg font-medium">Peserta tidak ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($participants->hasPages() || $participants->total() > 25)
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $participants->links('pagination::simple-tailwind') }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <p class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-medium">{{ $participants->firstItem() ?? 0 }}</span>
                        sampai
                        <span class="font-medium">{{ $participants->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-medium">{{ $participants->total() }}</span>
                        data
                    </p>
                    <div class="flex items-center gap-2">
                        <label for="per_page" class="text-sm text-gray-500">Baris:</label>
                        <select id="per_page" onchange="window.location.href = this.value" class="rounded-md border-gray-300 py-1 pl-2 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            @foreach([25, 50, 100] as $size)
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" {{ $perPage == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    {{ $participants->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
