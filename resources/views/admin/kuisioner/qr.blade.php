@extends('admin.layout')

@section('title', 'QR Code Kuisioner')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-lg mx-auto text-center">

    <h2 class="text-xl font-bold mb-2">QR Code Kuisioner</h2>

    <p class="text-gray-700 mb-1">
        Layanan:
        <span class="font-semibold">{{ $kuisioner->judul }}</span>
    </p>

    <p class="text-xs text-gray-500 mb-4 break-all">
        URL tujuan: {{ $targetUrl }}
    </p>

    <div class="flex justify-center mb-4">
        <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data={{ urlencode($targetUrl) }}"
            alt="QR Kuisioner {{ $kuisioner->judul }}"
            class="border rounded-lg shadow"
        >
    </div>

    <p class="text-gray-500 text-xs">
        Scan QR ini untuk mengisi kuisioner layanan
        <span class="font-semibold">{{ $kuisioner->judul }}</span>.
    </p>
</div>
@endsection
