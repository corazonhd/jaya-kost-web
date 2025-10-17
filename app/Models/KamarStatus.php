<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KamarStatus extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'kamar_status';

    // Primary key
    protected $primaryKey = 'nama_kamar';
    public $incrementing = false;
    protected $keyType = 'string';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama_kamar',
        'status',
    ];
}
