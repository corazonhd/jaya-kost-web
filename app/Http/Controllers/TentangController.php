<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TentangController extends Controller
{
    protected $path = 'content.json';

    // Tampilkan halaman edit
    public function edit()
    {
        $content = [
            'tentang' => '',
            'fasilitas_kamar' => '',
            'fasilitas_umum' => ''
        ];

        if (File::exists(storage_path($this->path))) {
            $content = json_decode(File::get(storage_path($this->path)), true);
        }

        return view('admin.profile', compact('content'));
    }

    // Update konten ke file JSON
    public function update(Request $request)
    {
        $request->validate([
            'tentang' => 'required|string',
            'fasilitas_kamar' => 'required|string',
            'fasilitas_umum' => 'required|string',
        ]);

        $data = [
            'tentang' => $request->tentang,
            'fasilitas_kamar' => $request->fasilitas_kamar,
            'fasilitas_umum' => $request->fasilitas_umum,
        ];

        File::put(storage_path($this->path), json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('admin.profile')->with('success', 'Konten berhasil diperbarui!');
    }
}