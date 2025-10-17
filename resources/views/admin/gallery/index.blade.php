<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Admin - Jaya Kost</title>
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
               class="px-3 py-1 rounded-md text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 text-sm">
               Beranda
            </a>
            <a href="{{ route('admin.gallery.index') }}"
               class="px-3 py-1 rounded-md bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 text-sm">
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

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-gradient-to-tr from-gray-950 via-gray-900 to-gray-800 w-full pt-16 md:pt-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl md:text-3xl font-bold text-cyan-400 drop-shadow-md">🎨 Galeri</h2>
            <a href="{{ route('admin.gallery.create') }}"
               class="px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-pink-400 hover:to-purple-500 transition">
               + Tambah Gambar
            </a>
        </div>

        @php
            if (!($galleries instanceof \Illuminate\Support\Collection) || !$galleries->keys()->contains('A')) {
                $tmp = collect($galleries)->groupBy('blok');
                $galleries = collect(['A','B','C'])->mapWithKeys(fn($b)=>[$b=>$tmp->get($b, collect())]);
            }
        @endphp

        @foreach($galleries as $blok => $items)
            <h3 class="text-xl font-bold text-pink-400 mb-4">📂 Blok {{ $blok }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
                @forelse($items as $gallery)
                    <div class="bg-gradient-to-br from-indigo-800 to-purple-900 rounded-2xl shadow-lg p-4 flex flex-col">
                        @if(!empty($gallery->image_url))
                            <img src="{{ $gallery->image_url }}"
                                 alt="{{ $gallery->title ?? 'No Title' }}"
                                 class="rounded-lg mb-2 h-48 w-full object-cover">
                        @else
                            <div class="bg-gray-700 h-48 rounded-lg mb-2 flex items-center justify-center text-gray-400">
                                Tidak ada gambar
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold text-cyan-300">{{ $gallery->title ?? 'No Title' }}</h3>
                        <p class="text-gray-400 text-sm">{{ $gallery->description ?? '' }}</p>

                        <div class="mt-2 flex justify-between">
                            <a href="{{ route('admin.gallery.edit', $gallery->id) }}"
                               class="px-2 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-500 transition">Edit</a>

                            <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus Gambar ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-500 transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-gray-500 italic">
                        Belum ada gambar di Blok {{ $blok }}.
                    </div>
                @endforelse
            </div>
        @endforeach
    </main>
</div>
</body>
</html>
