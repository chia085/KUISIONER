@extends('admin.layout')

@section('title', 'Daftar Kuisioner')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-teal-600">Daftar Layanan</h2>

        <a href="{{ route('admin.kuisioner.create') }}"
           class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700">
            + Buat Layanan Kuisioner
        </a>
    </div>

    <table class="w-full border text-sm rounded overflow-hidden">
        <thead class="bg-teal-600 text-white">
            <tr>
                <th class="p-3 text-left">Daftar Layanan</th>
                <th class="p-3 text-center">Aksi</th>
                <th class="p-3 text-center">Setting</th>
            </tr>
        </thead>

        <tbody>
            @foreach($kuisioners as $k)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">
                        <div class="font-semibold">{{ $k->judul }}</div>
                        <div class="text-xs text-gray-600">
                            {{ $k->deskripsi ?: 'Tanpa deskripsi' }}
                        </div>
                    </td>

                    <td class="p-3 text-center space-x-3">
                        <a href="{{ route('admin.kuisioner.edit', $k->id) }}"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <a href="{{ route('admin.kuisioner.qr', $k->id) }}"
                           class="text-blue-600 hover:underline">
                            QR Code
                        </a>

                        <form action="{{ route('admin.kuisioner.destroy', $k->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Hapus kuisioner ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>

                    <td class="p-3 text-center">
                        <form action="{{ route('admin.kuisioner.toggle', $k->id) }}"
                              method="POST"
                              class="inline-block">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1 rounded text-sm
                                {{ $k->status ? 'bg-green-200 text-green-800' : 'bg-gray-300 text-gray-700' }}">
                                {{ $k->status ? 'Aktif (Klik untuk Nonaktif)' : 'Nonaktif (Klik untuk Aktif)' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
