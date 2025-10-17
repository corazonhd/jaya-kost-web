<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Jaya Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100 font-sans">

    <!-- Sidebar + Navbar -->
    <div class="flex h-screen">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-purple-900 to-indigo-900 shadow-2xl flex flex-col">
            <div class="p-6 text-center">
                <h1 class="text-2xl font-extrabold text-cyan-400 tracking-widest drop-shadow-lg">ADMIN</h1>
            </div>
            <nav class="flex-1 px-4 space-y-3">
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 rounded-lg bg-indigo-800 text-cyan-300 hover:bg-indigo-700 hover:text-pink-400 transition">
                   Dashboard
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-purple-800 hover:text-cyan-300 transition">
                   Users
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="block px-4 py-2 rounded-lg text-gray-300 hover:bg-purple-800 hover:text-cyan-300 transition">
                   Reports
                </a>
            </nav>
            <div class="p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="w-full px-4 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:from-pink-400 hover:to-purple-500 transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto bg-gradient-to-tr from-gray-950 via-gray-900 to-gray-800">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-cyan-400 drop-shadow-md">⚡ Dashboard</h2>
                <p class="text-gray-400">Welcome back, Admin! Here’s what’s happening today.</p>
            </div>

            <!-- Dashboard Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-gradient-to-br from-indigo-800 to-purple-900 rounded-2xl shadow-lg hover:shadow-cyan-500/50 transition">
                    <h3 class="text-lg font-semibold text-cyan-300">Users</h3>
                    <p class="text-3xl font-bold text-white mt-2">1,248</p>
                </div>
                <div class="p-6 bg-gradient-to-br from-pink-800 to-purple-900 rounded-2xl shadow-lg hover:shadow-pink-500/50 transition">
                    <h3 class="text-lg font-semibold text-pink-300">Bookings</h3>
                    <p class="text-3xl font-bold text-white mt-2">326</p>
                </div>
                <div class="p-6 bg-gradient-to-br from-cyan-800 to-indigo-900 rounded-2xl shadow-lg hover:shadow-indigo-500/50 transition">
                    <h3 class="text-lg font-semibold text-cyan-300">Reports</h3>
                    <p class="text-3xl font-bold text-white mt-2">57</p>
                </div>
            </div>

            <!-- Content Slot -->
            <div class="mt-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
