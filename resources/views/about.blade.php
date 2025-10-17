@extends('layouts.app')

@section('title', 'Tentang Kami - Jaya Kost Group')

@section('content')
    <div class="container with-top-padding">
        <div class="tentang">
            <h3>Tentang Jaya Kost Group</h3>
            <br>
            {!! '<p>' . str_replace("\n", "</p><p>", e($content['tentang'])) . '</p>' !!}
        </div>

        <div class="fasilitas">
            <h3>Fasilitas Kamar</h3>
            <br>
            {!! nl2br(e($content['fasilitas_kamar'])) !!}
        </div>
        
        <div class="flts">
            <h3>Fasilitas Umum</h3>
            <br>
            {!! nl2br(e($content['fasilitas_umum'])) !!}
        </div>
        
        <div class="pertanyaan">
            <h3>Hubungi Kami</h3>
            <form id="pertanyaanForm" action="{{ route('save-message') }}" method="POST">
                @csrf
                <input type="text" name="nama" placeholder="Nama Anda" required>
                <input type="tel" name="telepon" placeholder="Nomor Telepon" required>
                <textarea name="pesan" rows="3" placeholder="Tulis pertanyaan Anda..." required></textarea>
                <button type="submit">Kirim</button>
            </form>
        </div>
    </div>
@endsection
