@extends('admin.layout')

@section('title','Daftar Pertanyaan')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">

    {{-- JUDUL --}}
    <h2 class="text-2xl font-bold text-teal-600 mb-4">Daftar Layanan</h2>

    {{-- FILTER KUISIONER --}}
    <form method="GET" action="{{ route('admin.pertanyaan.index') }}" class="flex items-center space-x-3 mb-4">
        <select name="kuisioner_id" class="border rounded p-2 text-sm w-64">
            <option value="">-- Pilih Layanan Kuisioner --</option>
            @foreach($kuisioners as $k)
                <option value="{{ $k->id }}" {{ $selected == $k->id ? 'selected' : '' }}>
                    {{ $k->judul }}
                </option>
            @endforeach
        </select>

        <button class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-teal-700">
            Tampilkan
        </button>
    </form>

    {{-- JIKA BELUM PILIH --}}
    @if(!$selected)
        <p class="text-gray-500 text-sm">Silakan pilih kuisioner terlebih dahulu.</p>
    @endif

    {{-- TABEL PERTANYAAN --}}
    @if($selected && $pertanyaan->count() > 0)
        <div class="overflow-x-auto mt-4">

            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 border">
                    <tr>
                        <th class="p-3 text-left">Pertanyaan</th>
                        <th class="p-3 text-left">Role</th>
                        <th class="p-3 text-left">Tipe</th>
                        <th class="p-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($pertanyaan as $p)
                    <tr class="border-b">
                        <td class="p-3">{{ $p->pertanyaan }}</td>
                        <td class="p-3">{{ ucfirst($p->role) }}</td>
                        <td class="p-3">{{ ucfirst(str_replace('_',' ',$p->tipe)) }}</td>

                        <td class="p-3 text-center">
                            <a href="{{ route('admin.pertanyaan.edit', $p->id) }}"
                               class="text-blue-600 hover:underline">Edit</a>

                            <form action="{{ route('admin.pertanyaan.destroy', $p->id) }}"
                                  method="POST" class="inline-block"
                                  onsubmit="return confirm('Hapus pertanyaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    @endif

    {{-- JIKA kosong --}}
    @if($selected && $pertanyaan->count() == 0)
        <p class="text-gray-500 mt-4">Belum ada pertanyaan untuk kuisioner ini.</p>
    @endif

    {{-- TAMBAH PERTANYAAN --}}
    @if($selected)
        <a href="{{ route('admin.pertanyaan.create',['kuisioner_id'=>$selected]) }}"
           class="mt-6 inline-block bg-teal-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-teal-700">
            + Tambah Pertanyaan
        </a>
    @endif

</div>

@endsection
