<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - Jaya Kost</title>
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
                class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 transition">
                Galeri
            </a>
            <a href="{{ route('admin.profile') }}" 
                class="block px-4 py-2 rounded-lg bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 transition">
                Profil
            </a>
            <a href="{{ route('admin.kamarstatus') }}" 
                class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 transition">
                Status Kamar
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
                class="px-3 py-1 rounded-md text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 text-sm">
                Galeri
            </a>
            <a href="{{ route('admin.profile') }}" 
                class="px-3 py-1 rounded-md bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 text-sm">
                Profil
            </a>
            <a href="{{ route('admin.kamarstatus') }}" 
                class="px-3 py-1 rounded-md text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 text-sm">
                Kamar
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

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-gradient-to-tr from-gray-950 via-gray-900 to-gray-800 w-full pt-16 md:pt-8">
        <div class="mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-cyan-400 drop-shadow-md">✍️ Profil</h2>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-600 text-white shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="tentang" class="block font-semibold text-cyan-300 mb-2">Tentang</label>
                <textarea name="tentang" id="tentang" rows="6" 
                    class="w-full rounded-xl bg-gray-800 text-gray-100 p-3 border border-gray-700 focus:ring-2 focus:ring-cyan-500 focus:outline-none">{{ old('tentang', $content['tentang']) }}</textarea>
            </div>

            <div>
                <label for="fasilitas_kamar" class="block font-semibold text-cyan-300 mb-2">Fasilitas Kamar</label>
                <textarea name="fasilitas_kamar" id="fasilitas_kamar" rows="6" 
                    class="w-full rounded-xl bg-gray-800 text-gray-100 p-3 border border-gray-700 focus:ring-2 focus:ring-cyan-500 focus:outline-none">{{ old('fasilitas_kamar', $content['fasilitas_kamar']) }}</textarea>
            </div>

            <div>
                <label for="fasilitas_umum" class="block font-semibold text-cyan-300 mb-2">Fasilitas Umum</label>
                <textarea name="fasilitas_umum" id="fasilitas_umum" rows="6" 
                    class="w-full rounded-xl bg-gray-800 text-gray-100 p-3 border border-gray-700 focus:ring-2 focus:ring-cyan-500 focus:outline-none">{{ old('fasilitas_umum', $content['fasilitas_umum']) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-xl text-white font-semibold shadow-lg hover:from-cyan-400 hover:to-blue-500 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </main>
</div>
</body>
</html>
