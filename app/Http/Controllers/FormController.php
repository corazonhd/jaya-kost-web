<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pesan;

class FormController extends Controller
{
    public function saveMessage(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        try {
            Pesan::create($validatedData);

            return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error saat menyimpan pesan: ' . $e->getMessage()]);
        }
    }
}