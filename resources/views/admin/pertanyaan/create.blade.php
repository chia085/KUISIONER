@extends('admin.layout')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-teal-600">Tambah Pertanyaan</h2>

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

    <form method="POST" action="{{ route('admin.pertanyaan.store') }}">
        @csrf

        {{-- PILIH KUISIONER --}}
        <label class="block mb-2 font-semibold">Pilih Layanan Kuisioner</label>
        <select name="kuisioner_id"
                id="kuisionerSelect"
                class="w-full border rounded p-2 mb-4"
                required>
            <option value="">-- Pilih Kuisioner --</option>
            @foreach($kuisioners as $k)
                <option value="{{ $k->id }}"
                    {{ (old('kuisioner_id', $selectedKuisionerId) == $k->id) ? 'selected' : '' }}>
                    {{ $k->judul }}
                </option>
            @endforeach
        </select>

        {{-- ROLE RESPONDEN (checkbox, hanya role yang diizinkan utk kuisioner tsb) --}}
        <label class="block mb-2 font-semibold">Role Responden</label>

        @if(empty($allowedRoles))
            <p class="text-xs text-gray-500 mb-4">
                Silakan pilih kuisioner terlebih dahulu untuk melihat role yang diizinkan.
            </p>
        @else
            <div class="border rounded p-3 mb-4 bg-gray-50 space-y-1 max-h-48 overflow-y-auto">
                @foreach($allowedRoles as $value)
                    @php
                        $label = $roleOptions[$value] ?? ucfirst($value);
                    @endphp
                    <label class="flex items-center space-x-2 text-sm">
                        <input type="checkbox"
                               name="roles[]"
                               value="{{ $value }}"
                               class="accent-teal-600"
                               {{ in_array($value, old('roles', [])) ? 'checked' : '' }}>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        @endif

        {{-- PERTANYAAN (bisa banyak) --}}
        <label class="block mb-2 font-semibold">Pertanyaan</label>

        <div id="questionsContainer" class="space-y-2 mb-4">
            @php
                $oldQuestions = old('pertanyaan', ['']);
            @endphp

            @foreach($oldQuestions as $idx => $q)
                <input type="text"
                       name="pertanyaan[]"
                       class="w-full border rounded-full px-4 py-2 text-sm"
                       placeholder="Tulis pertanyaan di sini"
                       value="{{ $q }}">
            @endforeach
        </div>

        <button type="button"
                id="btnAddQuestion"
                class="mb-4 inline-flex items-center px-3 py-1 rounded-full border text-xs text-teal-700 border-teal-500 hover:bg-teal-50">
            + Tambah Pertanyaan
        </button>

        {{-- TIPE PERTANYAAN --}}
        <label class="block mb-2 font-semibold mt-2">Tipe Pertanyaan</label>
        <select name="tipe" class="w-full border rounded p-2 mb-6" required>
            <option value="pilihan_ganda"
                {{ old('tipe') == 'pilihan_ganda' ? 'selected' : '' }}>
                Pilihan Ganda (Sangat Baik - Sangat Buruk)
            </option>
            <option value="isian"
                {{ old('tipe') == 'isian' ? 'selected' : '' }}>
                Isian Bebas
            </option>
        </select>

        <div class="flex items-center gap-3">
            <button class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 transition">
                Simpan
            </button>

            <a href="{{ route('admin.pertanyaan.index') }}"
               class="text-gray-600 hover:underline">
                Batal
            </a>
        </div>
    </form>
</div>

{{-- Script: reload saat kuisioner diganti + tambah field pertanyaan --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const selectK = document.getElementById('kuisionerSelect');
        const btnAdd = document.getElementById('btnAddQuestion');
        const container = document.getElementById('questionsContainer');

        if (selectK) {
            selectK.addEventListener('change', () => {
                const kuisionerId = selectK.value;
                const baseUrl = "{{ route('admin.pertanyaan.create') }}";

                if (kuisionerId) {
                    window.location.href = baseUrl + '?kuisioner_id=' + kuisionerId;
                } else {
                    window.location.href = baseUrl;
                }
            });
        }

        if (btnAdd && container) {
            btnAdd.addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'pertanyaan[]';
                input.className = 'w-full border rounded-full px-4 py-2 text-sm';
                input.placeholder = 'Tulis pertanyaan di sini';
                container.appendChild(input);
            });
        }
    });
</script>

@endsection
