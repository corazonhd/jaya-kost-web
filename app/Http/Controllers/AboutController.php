<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class AboutController extends Controller
{
    protected $path = 'content.json';

    public function show()
    {
        $content = [
            'tentang' => '',
            'fasilitas_kamar' => '',
            'fasilitas_umum' => ''
        ];

        if (File::exists(storage_path($this->path))) {
            $content = json_decode(File::get(storage_path($this->path)), true);
        }

        return view('about', compact('content'));
    }
}
