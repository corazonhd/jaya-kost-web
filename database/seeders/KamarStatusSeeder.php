<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\KamarStatus;

class KamarStatusSeeder extends Seeder
{
    public function run()
    {

        KamarStatus::truncate();

        $kamar = [
            ['nama_kamar' => 'A1', 'status' => 'Available'],
            ['nama_kamar' => 'A2', 'status' => 'Available'],
            ['nama_kamar' => 'A3', 'status' => 'Available'],
            ['nama_kamar' => 'A4', 'status' => 'Available'],
            ['nama_kamar' => 'A5', 'status' => 'Available'],
            ['nama_kamar' => 'A6', 'status' => 'Available'],
            ['nama_kamar' => 'B1', 'status' => 'Available'],
            ['nama_kamar' => 'B2', 'status' => 'Available'],
            ['nama_kamar' => 'B3', 'status' => 'Available'],
            ['nama_kamar' => 'B4', 'status' => 'Available'],
            ['nama_kamar' => 'C1', 'status' => 'Available'],
            ['nama_kamar' => 'C2', 'status' => 'Available'],
            ['nama_kamar' => 'C3', 'status' => 'Available'],
            ['nama_kamar' => 'C4', 'status' => 'Available'],
            ['nama_kamar' => 'C5', 'status' => 'Available'],
            ['nama_kamar' => 'C6', 'status' => 'Available'],
            ['nama_kamar' => 'C7', 'status' => 'Available'],
            ['nama_kamar' => 'C8', 'status' => 'Available'],
            ['nama_kamar' => 'C9', 'status' => 'Available'],
            ['nama_kamar' => 'C10', 'status' => 'Available'],
            ['nama_kamar' => 'C11', 'status' => 'Available'],
            ['nama_kamar' => 'C12', 'status' => 'Available'],
        ];

        KamarStatus::insert($kamar);
    }
}