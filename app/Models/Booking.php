<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'kamar_dipilih',
        'nama',
        'telepon',
        'email',
        'tanggal_masuk',
        'durasi_sewa',
        'harga',
        'invoice_id',
        'status_pembayaran',
        'jenis_pembayaran',
        'jumlah_bayar'
    ];
}