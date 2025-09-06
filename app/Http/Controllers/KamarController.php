<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KamarStatus;

class KamarController extends Controller
{
    public function getKamarStatus()
    {
        try {
            $kamar_data = KamarStatus::all();
            return response()->json(['success' => true, 'data' => $kamar_data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Koneksi database gagal: ' . $e->getMessage()]);
        }
    }
}