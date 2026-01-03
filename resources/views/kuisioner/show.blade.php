<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $kuisioner->judul }} - E-Kuisioner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="max-w-3xl mx-auto my-8">

    {{-- HEADER KUISIONER --}}
    <div class="bg-teal-600 text-white px-6 py-4 rounded-t-xl shadow">
        <h1 class="text-2xl font-bold">{{ $kuisioner->judul }}</h1>

        @if($kuisioner->deskripsi)
            <p class="mt-2 text-sm text-teal-100">
                {{ $kuisioner->deskripsi }}
            </p>
        @endif

        @isset($roleLabel)
            <p class="mt-2 text-xs text-teal-100">
                Anda mengisi sebagai: <span class="font-semibold">{{ $roleLabel }}</span>
            </p>
        @endisset
    </div>

    {{-- FORM PERTANYAAN --}}
    <div class="bg-white p-6 rounded-b-xl shadow">

        {{-- Pesan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($pertanyaans->isEmpty())
            <p class="text-center text-gray-500">
                Belum ada pertanyaan untuk kuisioner ini.
            </p>
        @else
            {{-- penting: action menyertakan ?role= --}}
            <form action="{{ route('kuisioner.submit', [$kuisioner->id, 'role' => $role]) }}" method="POST">
                @csrf

                @foreach($pertanyaans as $index => $p)
                    <div class="mb-6 border-b pb-4">
                        <p class="font-semibold mb-2">
                            {{ $index + 1 }}. {{ $p->pertanyaan }}
                        </p>

                        {{-- Pilihan ganda: Sangat Baik sampai Sangat Buruk --}}
                        @if($p->tipe === 'pilihan_ganda')
                            @php
                                $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Buruk', 'Sangat Buruk'];
                            @endphp
                            <div class="space-y-1">
                                @foreach($opsi as $o)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio"
                                               name="jawaban[{{ $p->id }}]"
                                               value="{{ $o }}"
                                               class="accent-teal-600"
                                               required>
                                        <span>{{ $o }}</span>
                                    </label>
                                @endforeach
                            </div>

                        {{-- Isian bebas --}}
                        @elseif($p->tipe === 'isian')
                            <textarea name="jawaban[{{ $p->id }}]"
                                      class="w-full border rounded p-2"
                                      rows="3"
                                      required></textarea>
                        @else
                            <p class="text-sm text-gray-500">
                                Tipe pertanyaan tidak dikenali.
                            </p>
                        @endif
                    </div>
                @endforeach

                <button type="submit"
                        class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 transition">
                    Kirim Jawaban
                </button>
            </form>
        @endif
    </div>
</div>

{{-- POPUP SUKSES SETELAH SUBMIT (tetap seperti punyamu) --}}
@if(session('sukses_kirim'))
    <div id="successOverlay"
         class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl px-8 py-6 max-w-md w-full text-center relative">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 rounded-full border-4 border-green-500 flex items-center justify-center animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-8 w-8 text-green-500"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Kirim Kuisioner Berhasil
            </h2>
            <p class="text-gray-600 text-sm mb-1">
                Terima kasih atas partisipasi Anda.
            </p>
            <p class="text-gray-500 text-xs mb-4">
                Anda akan diarahkan ke halaman utama dalam
                <span id="countdown" class="font-semibold">5</span> detik...
            </p>
            <a href="{{ route('kuisioner.grafik.responden', [$kuisioner->id, $role]) }}"
             class="block mt-3 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Lihat Grafik Hasil Anda
            </a>
            <button id="okButton"
                    class="mt-2 bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-700 transition">
                OK
            </button>
        </div>
    </div>

    <script>
        (function () {
            let detik = 5;
            const countdownEl = document.getElementById('countdown');
            const okBtn = document.getElementById('okButton');
            const redirectUrl = "{{ route('polibatam') }}";

            function redirectNow() {
                window.location.href = redirectUrl;
            }

            const timer = setInterval(function () {
                detik--;
                if (countdownEl) countdownEl.textContent = detik;
                if (detik <= 0) {
                    clearInterval(timer);
                    redirectNow();
                }
            }, 1000);

            if (okBtn) {
                okBtn.addEventListener('click', function () {
                    clearInterval(timer);
                    redirectNow();
                });
            }
        })();
    </script>
@endif

</body>
</html>
