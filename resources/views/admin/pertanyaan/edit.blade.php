@extends('admin.layout')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md max-w-xl mx-auto">
    <h2 class="text-2xl font-bold text-teal-600 mb-4">Edit Pertanyaan</h2>

    <form method="POST" action="{{ route('admin.pertanyaan.update', $pertanyaan->id) }}">
        @csrf
        @method('PUT')

        {{-- PERTANYAAN --}}
        <label class="block mb-2 font-semibold">Pertanyaan</label>
        <textarea name="pertanyaan" class="w-full border rounded p-2 mb-4" required>{{ $pertanyaan->pertanyaan }}</textarea>

        {{-- TIPE --}}
        <label class="block mb-2 font-semibold">Tipe Pertanyaan</label>
        <select name="tipe" class="w-full border rounded p-2 mb-4">
            <option value="pilihan_ganda" {{ $pertanyaan->tipe=='pilihan_ganda'?'selected':'' }}>Pilihan Ganda</option>
            <option value="isian" {{ $pertanyaan->tipe=='isian'?'selected':'' }}>Isian</option>
        </select>

        <button class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">
            Update
        </button>

        <a href="{{ route('admin.pertanyaan.index', ['kuisioner_id' => $pertanyaan->kuisioner_id]) }}" 
           class="ml-3 text-gray-600 hover:underline">Batal</a>
    </form>
</div>

@endsection
