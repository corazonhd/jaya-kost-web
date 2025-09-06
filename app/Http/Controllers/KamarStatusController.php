<?php

namespace App\Http\Controllers;

use App\Models\KamarStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KamarStatusController extends Controller
{
    public function index()
    {
        $kamar = DB::table('kamar_status')
            ->orderByRaw("LEFT(nama_kamar, 1) ASC") // urut huruf A, B, C
            ->orderByRaw("CAST(SUBSTRING(nama_kamar, 2) AS INTEGER) ASC") // urut angka
            ->get();
        return view('admin.kamarstatus', compact('kamar'));
    }

    public function update(Request $request, $nama_kamar)
    {
        $kamar = KamarStatus::findOrFail($nama_kamar);
        $kamar->update(['status' => $request->status]);

        return redirect()->route('admin.kamarstatus')->with('success', 'Status kamar berhasil diperbarui!');
    }
}
