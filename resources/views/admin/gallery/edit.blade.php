<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Galeri - Jaya Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 font-sans h-full">
<div class="flex h-screen overflow-hidden">
    <!-- SIDEBAR DESKTOP -->
    <aside class="hidden md:flex w-64 bg-gradient-to-b from-purple-900 to-indigo-900 shadow-2xl flex-col">
        <div class="p-6 text-center">
            <h1 class="text-2xl font-extrabold text-cyan-400 tracking-widest drop-shadow-lg">ADMIN</h1>
        </div>
        <nav class="flex-1 px-4 space-y-3">
            <a href="{{ route('dashboard') }}" 
               class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 transition">
               Beranda
            </a>
            <a href="{{ route('admin.gallery.index') }}" 
               class="block px-4 py-2 rounded-lg bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 transition">
               Edit Galeri
            </a>
        </nav>
        <div class="p-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" 
                    class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-pink-400 hover:to-purple-500 transition">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- NAVBAR MOBILE -->
    <nav class="flex md:hidden items-center justify-between bg-gradient-to-r from-purple-900 to-indigo-900 px-4 py-3 shadow-lg w-full fixed top-0 left-0 z-50">
        <h1 class="text-lg font-extrabold text-cyan-400 tracking-widest">ADMIN</h1>
        <div class="flex space-x-2">
            <a href="{{ route('dashboard') }}" 
               class="px-3 py-1 rounded-md text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 text-sm">
               Beranda
            </a>
            <a href="{{ route('admin.gallery.index') }}" 
               class="px-3 py-1 rounded-md bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 text-sm">
               Galeri
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                    class="px-3 py-1 rounded-md bg-pink-600 text-white hover:bg-pink-500 text-sm">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-gradient-to-tr from-gray-950 via-gray-900 to-gray-800 w-full pt-16 md:pt-8">
        <div class="mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-cyan-400 drop-shadow-md">✏️ Edit Galeri</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-700 text-white p-4 rounded mb-4 shadow">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 w-full max-w-lg">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block mb-1 text-cyan-300 font-semibold">Judul</label>
                <input type="text" name="title" value="{{ $gallery->title }}" 
                       class="w-full p-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400">
            </div>

            <!-- Blok -->
            <div>
                <label class="block mb-1 text-cyan-300 font-semibold">Pilih Blok</label>
                <div class="flex gap-4">
                    @foreach(['A','B','C'] as $blok)
                        <label class="flex items-center gap-2">
                            <input type="radio" name="blok" value="{{ $blok }}" class="accent-cyan-400"
                                {{ $gallery->blok === $blok ? 'checked' : '' }}>
                            Blok {{ $blok }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Upload Gambar Baru -->
            <div>
                <label class="block mb-1 text-cyan-300 font-semibold">Upload Gambar Baru</label>
                <input type="file" name="image" id="images" accept="image/*"
                       class="w-full text-gray-200 bg-gray-700 p-2 rounded focus:outline-none">
            </div>

            <!-- Preview Gambar Saat Ini -->
            <div>
                <p class="mb-2 text-gray-400">Gambar Saat Ini:</p>
                <div id="current-preview" class="grid grid-cols-3 gap-4">
                    @if(!empty($gallery->image_url))
                        <img src="{{ $gallery->image_url }}" class="rounded-lg h-32 object-cover">
                    @else
                        <p class="text-gray-500">Belum ada gambar</p>
                    @endif
                </div>
            </div>

            <!-- Preview Gambar Baru -->
            <div id="preview" class="grid grid-cols-3 gap-4 mb-4"></div>

            <!-- Submit -->
            <div>
                <button type="submit" 
                        class="px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-pink-400 hover:to-purple-500 transition">
                    Perbarui
                </button>
            </div>
        </form>
    </main>
</div>

<!-- Script Preview Gambar Baru -->
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
                img.className = 'rounded-lg h-32 object-cover';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>

</body>
</html>
