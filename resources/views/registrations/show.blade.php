@extends('layouts.app')
@section('title', 'Detail Pendaftaran')
@php $header = 'Detail Pendaftaran'; @endphp

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-900">Informasi Pendaftaran</h2>
        <div class="space-x-2">
            <a href="{{ route('registrations.edit', $registration) }}" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Edit</a>
            <form action="{{ route('registrations.destroy', $registration) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button></form>
        </div>
    </div>
    <div class="px-6 py-4">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div><dt class="text-sm font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm text-gray-900">{{ $registration->id }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Kategori</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <a href="{{ route('tournament-categories.show', $registration->category) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->category->name }}</a>
                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->category->category_type->color() }}">
                        {{ $registration->category->category_type->label() }}
                    </span>
                </dd>
            </div>
            <div><dt class="text-sm font-medium text-gray-500">Peserta</dt><dd class="mt-1 text-sm text-gray-900">{{ $registration->participant->name }}</dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Kontingen</dt><dd class="mt-1 text-sm text-gray-900"><a href="{{ route('contingents.show', $registration->contingent) }}" class="text-blue-600 hover:text-blue-800">{{ $registration->contingent->name }}</a></dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Status</dt><dd class="mt-1 text-sm text-gray-900"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->status->color() }}">{{ $registration->status->label() }}</span></dd></div>
            <div><dt class="text-sm font-medium text-gray-500">Medali</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if($registration->medal)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $registration->medal->color() }}">
                            {{ $registration->medal->label() }}
                        </span>
                    @else
                        Tidak ada medali
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>
@endsection
