@extends('admin.layout')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-teal-600">Edit Kuisioner</h2>

        <a href="{{ route('admin.dashboard') }}"
           class="hidden md:inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs hover:bg-gray-200">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.kuisioner.update', $kuisioner->id) }}">
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <label class="block mb-2 font-semibold">Judul Kuisioner</label>
        <input type="text" name="judul"
               value="{{ old('judul', $kuisioner->judul) }}"
               class="w-full border rounded p-2 mb-4" required>

        {{-- Deskripsi --}}
        <label class="block mb-2 font-semibold">Deskripsi</label>
        <textarea name="deskripsi"
                  class="w-full border rounded p-2 mb-4"
                  rows="4">{{ old('deskripsi', $kuisioner->deskripsi) }}</textarea>

        {{-- Target Responden --}}
        <label class="block mb-2 font-semibold">Target Responden</label>
        @php
            $selected = old('target_user', $selectedRoles ?? []);
        @endphp
        <div class="border rounded p-3 mb-4 space-y-1 bg-gray-50 max-h-64 overflow-y-auto">
            @foreach($roleOptions as $value => $label)
                <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox"
                           name="target_user[]"
                           value="{{ $value }}"
                           class="accent-teal-600"
                           {{ in_array($value, $selected) ? 'checked' : '' }}>
                    <span>{{ $label }}</span>
                </label>
            @endforeach
        </div>

        <button class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 transition">
            Update
        </button>

        <a href="{{ route('admin.kuisioner.index') }}"
           class="ml-3 text-gray-600 hover:underline">
            Batal
        </a>
    </form>
</div>

@endsection
