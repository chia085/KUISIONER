<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $kuisioner->judul }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
    <link rel="icon" type="image/png" href="{{ asset('images/polibatam.png') }}">
</head>
<body class="bg-gray-100 flex flex-col items-center p-6" x-data="{ loading: false, success: false }">

    <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-2xl transition-all duration-500" 
         :class="{ 'opacity-50 pointer-events-none': loading }">
        <!-- Judul Kuisioner -->
        <h2 class="text-2xl font-bold text-green-700 mb-2">{{ $kuisioner->judul }}</h2>
        <p class="text-gray-600 mb-6">{{ $kuisioner->deskripsi }}</p>

        <!-- Form -->
        <form id="kuisionerForm" action="{{ route('kuisioner.submit', $kuisioner->id) }}" method="POST" 
              @submit.prevent="
                loading = true;
                fetch($el.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify(Object.fromEntries(new FormData($el)))
                })
                .then(res => {
                    if(res.ok) {
                        success = true;
                        setTimeout(() => window.location.href = '/polibatam', 2000);
                    } else {
                        alert('Terjadi kesalahan, coba lagi.');
                        loading = false;
                    }
                })
              ">
            @csrf

            @foreach ($pertanyaans as $index => $p)
                <div class="mb-5">
                    <p class="font-semibold text-gray-800 mb-2">
                        {{ $index + 1 }}. {{ $p->teks_pertanyaan }}
                    </p>

                    @if ($p->tipe_jawaban === 'skala')
                        @php
                            $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang', 'Sangat Kurang'];
                        @endphp
                        <div class="flex flex-col ml-4 space-y-1">
                            @foreach ($opsi as $nilai)
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="jawaban[{{ $p->id }}]" value="{{ $nilai }}" class="accent-green-600" required>
                                    <span>{{ $nilai }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <textarea name="jawaban[{{ $p->id }}]" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:outline-none" rows="3" required></textarea>
                    @endif
                </div>
            @endforeach

            <!-- Tombol Submit -->
            <div class="mt-6 text-center">
                <button type="submit" 
                        class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition transform hover:scale-105"
                        :disabled="loading">
                    <span x-show="!loading">Kirim Jawaban</span>
                    <span x-show="loading" class="flex justify-center items-center space-x-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>Mengirim...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Pesan Sukses -->
        <div x-show="success" x-transition class="mt-6 text-center text-green-700 font-semibold">
            ✅ Jawaban berhasil dikirim! Anda akan diarahkan kembali...
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6 text-center">
            <a href="/polibatam" class="text-green-600 font-semibold hover:underline">&larr; Kembali ke halaman utama</a>
        </div>
    </div>

</body>
</html>
