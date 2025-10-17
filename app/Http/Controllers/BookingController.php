<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;
use App\Models\KamarStatus;
use Xendit\Xendit;
use Xendit\Invoice;

class BookingController extends Controller
{
    public function processBooking(Request $request)
    {
        $validatedData = $request->validate([
            'kamar_dipilih' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'tanggal_masuk' => 'required|date',
            'durasi_sewa' => 'required|integer|min:1|max:12',
            'harga_per_bulan' => 'required|numeric',
            'is_dp' => 'required|in:true,false'
        ]);

        $hargaSewaTotal = $validatedData['durasi_sewa'] * $validatedData['harga_per_bulan'];
        $isDp = $validatedData['is_dp'] === 'true';

        $jumlahBayar = $isDp ? $hargaSewaTotal * 0.30 : $hargaSewaTotal;
        $invoiceId = 'INV-' . time() . '-' . uniqid();

        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'kamar_dipilih' => $validatedData['kamar_dipilih'],
                'nama' => $validatedData['nama'],
                'telepon' => $validatedData['telepon'],
                'email' => $validatedData['email'],
                'tanggal_masuk' => $validatedData['tanggal_masuk'],
                'durasi_sewa' => $validatedData['durasi_sewa'],
                'harga' => $hargaSewaTotal,
                'invoice_id' => $invoiceId,
                'status_pembayaran' => 'PENDING',
                'jenis_pembayaran' => $isDp ? 'DP' : 'FULL',
                'jumlah_bayar' => $jumlahBayar,
            ]);

            Xendit::setApiKey(config('services.xendit.secret_key'));

            $params = [
                'external_id' => $invoiceId,
                'amount' => $jumlahBayar,
                'payer_email' => $validatedData['email'] ?? 'customer@email.com',
                'description' => 'Pembayaran ' . ($isDp ? 'DP 30%' : 'Penuh') . ' Sewa Kost ' . $validatedData['kamar_dipilih'] . ' selama ' . $validatedData['durasi_sewa'] . ' bulan.',
                'customer' => [
                    'given_names' => $validatedData['nama'],
                    'email' => $validatedData['email'] ?? 'customer@email.com',
                    'mobile_number' => $validatedData['telepon'],
                ],
                'invoice_duration' => 86400,
                'success_redirect_url' => env('APP_URL') . '/booking/success?external_id=' . $invoiceId,
                'failure_redirect_url' => env('APP_URL') . '/booking/fail',
            ];
            
            $createInvoice = Invoice::create($params);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice berhasil dibuat.',
                'redirect_url' => $createInvoice['invoice_url']
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Xendit Invoice Creation Error: ' . $e->getMessage());
            Log::error('Booking Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error saat memproses pemesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $externalId = $request->get('external_id');

        if (!$externalId) {
            return view('success')->with('booking', null);
        }

        // Update Kamar
        $booking = Booking::where('invoice_id', $externalId)->first();    
        if ($booking) {
            $kamar = KamarStatus::where('nama_kamar', $booking->kamar_dipilih)->first();
            if ($kamar && $kamar->status !== 'Booked') {
                $kamar->status = 'Booked';
                $kamar->save();
            }
        }

        return view('success', compact('booking'));
    }
}