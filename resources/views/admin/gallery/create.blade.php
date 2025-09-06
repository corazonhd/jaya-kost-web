<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Gambar Galeri - Jaya Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-900 text-gray-100 flex flex-col items-center p-8">

    <h1 class="text-3xl font-bold text-cyan-400 mb-6 drop-shadow-md">🖼️ Tambah Gambar Galeri</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if($errors->any())
        <div class="bg-red-700 text-white p-4 rounded mb-4 shadow">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" 
          class="w-full max-w-lg bg-gray-800 p-6 rounded-2xl shadow-lg">
        @csrf

        <!-- Judul Gambar -->
        <div class="mb-4">
            <label for="title" class="block text-cyan-300 font-semibold mb-2">Judul Gambar</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="w-full p-2 rounded bg-gray-700 text-white 
                          focus:outline-none focus:ring-2 focus:ring-cyan-400">
        </div>

        <!-- Pilih Blok -->
        <div class="mb-4">
            <label class="block text-cyan-300 font-semibold mb-2">Pilih Blok</label>
            <div class="flex gap-4">
                @foreach(['A','B','C'] as $blok)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="blok" value="{{ $blok }}" 
                               {{ old('blok') === $blok ? 'checked' : '' }}
                               required class="accent-cyan-400">
                        Blok {{ $blok }}
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Upload Multiple Images -->
        <div class="mb-4">
            <label for="images" class="block text-cyan-300 font-semibold mb-2">
                Upload Gambar
            </label>
            <input type="file" name="images[]" id="images" accept="image/*" multiple
                   class="w-full text-gray-200 bg-gray-700 p-2 rounded focus:outline-none">
        </div>

        <!-- Preview Gambar -->
        <div id="preview" class="grid grid-cols-3 gap-4 mb-4"></div>

        <!-- Tombol -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.gallery.index') }}"
               class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg 
                      hover:bg-gray-500 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 
                           text-white font-semibold rounded-lg 
                           hover:from-pink-400 hover:to-purple-500 transition">
                Tambah Gambar
            </button>
        </div>
    </form>

    {{-- Script Preview Gambar --}}
    <script>
        const imagesInput = document.getElementById('images');
        const preview = document.getElementById('preview');

        imagesInput.addEventListener('change', () => {
            preview.innerHTML = '';
            Array.from(imagesInput.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'rounded-lg w-full h-32 object-cover';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>
</html>
