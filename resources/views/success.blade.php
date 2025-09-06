<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-900 text-gray-100 font-sans min-h-screen flex items-center justify-center p-4">
    <div class="bg-gray-800 rounded-2xl shadow-lg p-8 max-w-md w-full">
        <div class="flex justify-center text-green-500 text-6xl mb-4">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="text-center text-2xl font-bold mb-6">Pembayaran Berhasil!</h1>
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-center mb-2">Detail Pemesanan</h2>
            <div class="flex justify-between">
                <span>Kamar:</span>
                <strong>{{ $booking->kamar_dipilih }}</strong>
            </div>
            <div class="flex justify-between">
                <span>Nama:</span>
                <strong>{{ $booking->nama }}</strong>
            </div>
            <div class="flex justify-between">
                <span>Tanggal Masuk:</span>
                <strong>{{ \Carbon\Carbon::parse($booking->tanggal_masuk)->format('d F Y') }}</strong>
            </div>
            <div class="flex justify-between">
                <span>Durasi Sewa:</span>
                <strong>{{ $booking->durasi_sewa }} Bulan</strong>
            </div>
            <div class="flex justify-between">
                <span>Total Pembayaran:</span>
                <strong>Rp {{ number_format($booking->jumlah_bayar, 0, ',', '.') }}</strong>
            </div>
        </div>
        <div class="mt-8 flex justify-between">
            <a href="{{ url('/') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-semibold transition">Kembali ke Beranda</a>
            <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg text-white font-semibold transition">
                <i class="fas fa-print mr-2"></i> Cetak Bukti
            </button>
        </div>
    </div>
</body>
</html>
