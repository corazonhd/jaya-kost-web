<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->all();

        // Simpan JSON untuk debug
        file_put_contents(storage_path('xendit_payload.json'), json_encode($data, JSON_PRETTY_PRINT));

        // Cari booking berdasarkan external_id
        $booking = Booking::where('invoice_id', $data['external_id'])->first();

        if ($booking && strtoupper($data['status']) === 'PAID') {
            $booking->update(['status_pembayaran' => 'SUCCESS']);
            Log::info('Booking updated to SUCCESS: ' . $booking->id);
        } else {
            Log::warning('Booking not found or status not PAID', $data);
        }

        return response()->json(['status' => 'ok']);
    }
}
