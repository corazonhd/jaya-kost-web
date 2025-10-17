<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin - Jaya Kost</title>
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
                class="block px-4 py-2 rounded-lg bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 transition">
                Beranda
            </a>
            <a href="{{ route('admin.gallery.index') }}" 
                class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 transition">
                Galeri
            </a>
            <a href="{{ route('admin.profile') }}" 
                class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 transition">
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
                class="px-3 py-1 rounded-md bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 text-sm">
                Dashboard
            </a>
            <a href="{{ route('admin.gallery.index') }}" 
                class="px-3 py-1 rounded-md text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 text-sm">
                Galeri
            </a>
                <a href="{{ route('admin.profile') }}" 
                class="px-3 py-1 rounded-md text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 text-sm">
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
        <div class="mb-4 md:mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-cyan-400 drop-shadow-md">⚡ Beranda Admin</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Users Widget -->
            <a href="{{ route('admin.users') }}"
                class="p-4 md:p-6 bg-gradient-to-br from-indigo-800 to-purple-900 rounded-2xl shadow-lg hover:shadow-cyan-500/50 transition">
                <h3 class="text-base md:text-lg font-semibold text-cyan-300">Penghuni</h3>
                <p class="text-2xl md:text-3xl font-bold text-white mt-2">{{ $userCount ?? 0 }}</p>
            </a>
            <!-- Bookings Widget -->
            <a href="{{ route('admin.bookings') }}"
                class="p-4 md:p-6 bg-gradient-to-br from-pink-800 to-purple-900 rounded-2xl shadow-lg hover:shadow-pink-500/50 transition">
                <h3 class="text-base md:text-lg font-semibold text-pink-300">Pemesanan</h3>
                <p class="text-2xl md:text-3xl font-bold text-white mt-2">{{ $bookingCount ?? 0 }}</p>
            </a>
            <!-- Pesan Widget -->
            <a href="{{ route('admin.pesan') }}"
                class="p-4 md:p-6 bg-gradient-to-br from-cyan-800 to-indigo-900 rounded-2xl shadow-lg hover:shadow-indigo-500/50 transition">
                <h3 class="text-base md:text-lg font-semibold text-cyan-300">Pesan</h3>
                <p class="text-2xl md:text-3xl font-bold text-white mt-2">{{ $messagesCount ?? 0 }}</p>
            </a>
        </div>
    </main>
</div>
</body>
</html>