@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <h2 class="text-xl font-bold text-teal-700">Jawaban Responden</h2>
                <p class="text-sm text-gray-600">Filter berdasarkan kuisioner, tanggal, dan tipe jawaban.</p>
            </div>

            <a href="{{ route('admin.jawaban.export.pdf', request()->query()) }}"
               class="bg-red-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-700">
               Export PDF
            </a>
        </div>

        <form method="GET" action="{{ route('admin.jawaban.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end mb-6">
            <div>
                <label class="block text-sm font-semibold mb-1">Kuisioner</label>
                <select name="kuisioner_id" class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua Kuisioner</option>
                    @foreach($kuisioners as $k)
                        <option value="{{ $k->id }}" {{ ($selectedKuisioner==$k->id) ? 'selected' : '' }}>
                            {{ $k->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tipe Jawaban</label>
                <select name="tipe" class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="" {{ $tipe=='' ? 'selected' : '' }}>Semua</option>
                    <option value="pilihan" {{ $tipe=='pilihan' ? 'selected' : '' }}>Pilihan Ganda</option>
                    <option value="saran" {{ $tipe=='saran' ? 'selected' : '' }}>Saran / Isian</option>
                </select>
            </div>

            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-700">
                    Filter
                </button>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="px-3 py-2 border">Waktu</th>
                        <th class="px-3 py-2 border">Kuisioner</th>
                        <th class="px-3 py-2 border">Pertanyaan</th>
                        <th class="px-3 py-2 border">Role</th>
                        <th class="px-3 py-2 border">Jawaban</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jawabans as $j)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-3 py-2 border whitespace-nowrap">
                                {{ optional($j->created_at)->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-3 py-2 border">
                                {{ $j->kuisioner->judul ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border">
                                {{ $j->pertanyaan->pertanyaan ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border">
                                {{ $j->role ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border">
                                {{ $j->jawaban ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Tidak ada data jawaban.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
