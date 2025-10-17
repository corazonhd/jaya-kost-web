<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghuni - Jaya Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 font-sans h-full">
<div class="flex h-screen overflow-hidden">
    
    <!-- SIDEBAR DESKTOP -->
    <aside class="hidden md:flex w-64 h-full bg-gradient-to-b from-purple-900 to-indigo-900 shadow-2xl flex-col fixed">
        <div class="p-6 text-center">
            <h1 class="text-2xl font-extrabold text-cyan-400 tracking-widest drop-shadow-lg">ADMIN</h1>
        </div>
        <nav class="flex-1 px-4 space-y-3">
            <a href="{{ route('dashboard') }}" 
               class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-indigo-800 hover:text-cyan-300 transition">
               Beranda
            </a>
            <a href="{{ route('admin.users') }}" 
               class="block px-4 py-2 rounded-lg bg-indigo-800 text-cyan-300 transition">
               Penghuni
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
               class="px-3 py-2 rounded-md bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 text-sm">
               Beranda
            </a>
            <a href="{{ route('admin.users') }}" 
               class="px-3 py-2 rounded-md text-gray-300 bg-indigo-800 text-cyan-300 text-sm">
               Penghuni
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                    class="px-3 py-2 rounded-md bg-pink-600 text-white hover:bg-pink-500 text-sm">
                    Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-gradient-to-tr from-gray-950 via-gray-900 to-gray-800 w-full md:ml-64 pt-16 md:pt-8">
        <div class="mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-cyan-400 drop-shadow-md">👥 Penghuni</h2>
            <p class="text-gray-400">Daftar semua penghuni yang terdaftar di sistem</p>
        </div>

        <!-- Users Table -->
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-800 to-purple-900 text-gray-200">
                        <th class="p-3">ID</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">No. Telepon</th>
                        <th class="p-3">KTP</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Email Verified</th>
                        <th class="p-3">Dibuat pada</th>
                        <th class="p-3">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                            <td class="p-3">{{ $user['id'] }}</td>
                            <td class="p-3">{{ $user['name'] }}</td>
                            <td class="p-3">{{ $user['email'] }}</td>
                            <td class="p-3">{{ $user['phone'] ?? '-' }}</td>
                            <td class="p-3">
                                @if(!empty($user['ktp_url']))
                                    <a href="{{ $user['ktp_url'] }}" target="_blank" class="text-blue-400 underline">Lihat KTP</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-3">{{ $user['role'] ?? '-' }}</td>
                            <td class="p-3">
                                @if($user['email_verified_at'])
                                    <span class="text-green-400">✔ Verified</span>
                                @else
                                    <span class="text-red-400">✖ Not Verified</span>
                                @endif
                            </td>
                            <td class="p-3">{{ $user['created_at'] ?? '-' }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.users.destroy', $user['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-2 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-400">Tidak ada data user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
