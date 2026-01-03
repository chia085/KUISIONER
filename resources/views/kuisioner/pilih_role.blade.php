<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Responden - {{ $kuisioner->judul }} - E-Kuisioner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

<div class="max-w-3xl mx-auto my-10">

    <div class="bg-teal-600 text-white px-6 py-4 rounded-t-xl shadow">
        <h1 class="text-2xl font-bold">Pilih Jenis Responden</h1>
        <p class="mt-2 text-sm text-teal-100">
            Sebelum mengisi, silakan pilih Anda sebagai apa pada kuisioner ini.
        </p>
        <p class="mt-1 text-xs text-teal-50">
            Kuisioner: <span class="font-semibold">{{ $kuisioner->judul }}</span>
        </p>
    </div>

    <div class="bg-white p-6 rounded-b-xl shadow">

        {{-- Tambahan safety agar tidak error walau controller salah --}}
        @php
            $allowedRoles = is_array($allowedRoles ?? null) ? $allowedRoles : [];
        @endphp

        @if(empty($allowedRoles))
            <p class="text-gray-500 text-center">
                Kuisioner ini belum memiliki jenis responden yang diizinkan.
                Silakan hubungi admin.
            </p>
        @else
            <form method="GET" action="{{ route('kuisioner.show', $kuisioner->id) }}">
                <p class="font-semibold mb-3">Saya adalah:</p>

                <div class="space-y-2 mb-6">
                    @foreach($allowedRoles as $value)
                        @php
                            $label = $roleOptions[$value] ?? ucfirst($value);
                        @endphp
                        <label class="flex items-center space-x-2">
                            <input type="radio"
                                   name="role"
                                   value="{{ $value }}"
                                   class="accent-teal-600"
                                   required>
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                <button type="submit"
                        class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-700 transition">
                    Lanjutkan
                </button>
            </form>
        @endif

    </div>

</div>

</body>
</html>
