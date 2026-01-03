@extends('admin.layout')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md max-w-2xl mx-auto">

    <h2 class="text-2xl font-bold text-teal-700 mb-4">
        Pilih Grafik Kuisioner
        <a href="{{ route('admin.dashboard') }}"
           class="hidden md:inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-lg text-xs hover:bg-gray-200">
            &larr; Kembali ke Dashboard
        </a>
    </h2>
    
    <div class="space-y-3">
        @foreach($kuisioners as $k)
            <a href="{{ route('admin.grafik.layanan', $k->id) }}"
               class="block p-3 border rounded-lg hover:bg-gray-100">
                {{ $k->judul }}
            </a>
            
        @endforeach
    </div>

</div>

@endsection
