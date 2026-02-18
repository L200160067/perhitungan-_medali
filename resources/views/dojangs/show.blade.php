<x-app-layout title="Detail Dojang">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $dojang->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-between items-center">
                <a href="{{ route('dojangs.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm transition">← Kembali ke Dojang</a>
                <div class="space-x-2">
                    <a href="{{ route('dojangs.edit', $dojang) }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-blue-600 transition">Edit</a>
                    <form action="{{ route('dojangs.destroy', $dojang) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dojang ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:visible:outline focus:visible:outline-2 focus:visible:outline-offset-2 focus:visible:outline-red-600 transition">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Dojang</h2>
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $dojang->id }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $dojang->name }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dibuat Pada</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $dojang->created_at->format('d M Y H:i') }}</dd></div>
                    <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Diperbarui Pada</dt><dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $dojang->updated_at->format('d M Y H:i') }}</dd></div>
                </dl>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Peserta ({{ $dojang->participants->count() }})</h2>
                    <a href="{{ route('participants.create', ['dojang_id' => $dojang->id]) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition">+ Tambah Peserta</a>
                </div>
                @if($dojang->participants->isNotEmpty())
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Jenis Kelamin</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dojang->participants as $participant)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('participants.show', $participant) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">{{ $participant->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $participant->gender->label() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $participant->birth_date->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    <p>Belum ada peserta</p>
                </div>
                @endif
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Kontingen ({{ $dojang->contingents->count() }})</h2>
                </div>
                @if($dojang->contingents->isNotEmpty())
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Pertandingan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($dojang->contingents as $contingent)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('contingents.show', $contingent) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">{{ $contingent->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <a href="{{ route('events.show', $contingent->event) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">{{ $contingent->event->name ?? 'Pertandingan #' . $contingent->event_id }}</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    <p>Belum ada kontingen</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
