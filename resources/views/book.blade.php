@extends('layouts.app')

@section('title', 'Pesan Sekarang - Jaya Kost Group')

@section('content')
<div class="container with-top-padding">
    <div class="katalog-row">
        <div class="blok">
            <img src="{{ asset('images/blok-a.png') }}" alt="Blok A">
            <h2>Blok A</h2>
            <div class="info">6 Kamar • Kamar mandi luar</div>
            <div class="harga">Rp. 1.000.000 / bulan</div>
            <div class="kamar-list">
                @foreach(['A1', 'A2', 'A3', 'A4', 'A5', 'A6'] as $kamar)
                    <div class="kamar" data-kamar-id="{{ $kamar }}">
                        {{ $kamar }} <span class="status">Loading...</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="blok">
            <img src="{{ asset('images/blok-b.png') }}" alt="Blok B">
            <h2>Blok B</h2>
            <div class="info">4 Kamar • Kamar mandi dalam</div>
            <div class="harga">Rp. 1.200.000 / bulan</div>
            <div class="kamar-list">
                @foreach(['B1', 'B2', 'B3', 'B4'] as $kamar)
                    <div class="kamar" data-kamar-id="{{ $kamar }}">
                        {{ $kamar }} <span class="status">Loading...</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="blok">
            <img src="{{ asset('images/blok-c.png') }}" alt="Blok C">
            <h2>Blok C</h2>
            <div class="info">12 Kamar • Kamar mandi dalam</div>
            <div class="harga">Rp. 1.200.000 / bulan</div>
            <div class="kamar-list">
                @foreach(range(1, 12) as $i)
                    <div class="kamar" data-kamar-id="C{{ $i }}">
                        C{{ $i }} <span class="status">Loading...</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Form Pemesanan --}}
    <div class="pertanyaan">
        <h3>Formulir Pemesanan</h3>
        <p style="color:white;">Kamar yang Anda pilih: <strong id="selectedRoom">Belum ada</strong></p>

        @guest
            <p style="color:yellow;">Silakan <a href="{{ route('login') }}" style="color:yellow;">login</a> terlebih dahulu untuk memesan kamar.</p>
            <form id="bookingForm" style="pointer-events:none; opacity:0.5;">
                <input type="text" placeholder="Nama Lengkap" disabled>
                <input type="tel" placeholder="Nomor Telepon" disabled>
                <input type="email" placeholder="Alamat Email" disabled>
                <input type="date" disabled>
                <input type="number" disabled>
                <button type="submit" disabled>Kirim Pemesanan</button>
            </form>
        @else
        <form id="bookingForm" action="{{ route('process_booking') }}" method="POST">
            @csrf
            <input type="hidden" name="kamar_dipilih" id="kamar_dipilih">
            <input type="hidden" name="harga_per_bulan" id="harga_per_bulan" value="0">

            <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ Auth::user()->name }}" required readonly>
            <input type="tel" name="telepon" placeholder="Nomor Telepon" value="{{ Auth::user()->phone  ?? '' }}" required readonly>
            <input type="email" name="email" placeholder="Alamat Email (opsional)" value="{{ Auth::user()->email }}" readonly>

            <label for="tanggal_masuk" style="color:white;">Tanggal Rencana Masuk</label>
            <input type="date" name="tanggal_masuk" id="tanggal_masuk" required>

            <label for="durasi_sewa" style="color:white;">Durasi Sewa (bulan)</label>
            <input type="number" name="durasi_sewa" id="durasi_sewa" min="1" max="12" value="1" required>

            <div class="payment-option">
                <span style="color:white;">Bayar Penuh</span>
                <label class="switch">
                    <input type="checkbox" id="dpToggle">
                    <span class="slider round"></span>
                </label>
                <span style="color:white;">Bayar DP 30%</span>
            </div>

            <p style="color:white;">Total Pembayaran: <strong id="totalHarga">Rp. 0</strong></p>

            <button type="submit">Kirim Pemesanan</button>
        </form>
        @endguest
    </div>
</div>
@endsection