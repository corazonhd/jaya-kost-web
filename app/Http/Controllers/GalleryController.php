<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

class GalleryController extends Controller
{
    /**
     * Tampilkan halaman galeri publik.
     * Mengirimkan $blokA, $blokB, $blokC ke view (sesuai view yang kamu pakai).
     */
    public function index()
    {
        $blokA = Gallery::where('blok', 'A')->orderBy('order_index')->get();
        $blokB = Gallery::where('blok', 'B')->orderBy('order_index')->get();
        $blokC = Gallery::where('blok', 'C')->orderBy('order_index')->get();

        return view('gallery', compact('blokA', 'blokB', 'blokC'));
    }

    // alias kalau ada route yg memanggil publicIndex
    public function publicIndex()
    {
        return $this->index();
    }
}
