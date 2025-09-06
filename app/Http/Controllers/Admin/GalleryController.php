<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use GuzzleHttp\Client;
use App\Events\GalleryUpdated;

class GalleryController extends Controller
{
    // Tampilkan semua gallery
    public function index()
    {
        $rows = \App\Models\Gallery::query()
            ->orderBy('blok')
            ->orderBy('order_index')
            ->orderBy('id')
            ->get();

    $grouped = $rows->groupBy('blok');

    $galleries = collect(['A','B','C'])
        ->mapWithKeys(fn ($b) => [$b => $grouped->get($b, collect())]);

    return view('admin.gallery.index', compact('galleries'));
    }

    // Form tambah gallery
    public function create()
    {
        return view('admin.gallery.create');
    }

    // Simpan gallery baru (multiple images)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'blok' => 'required|string|in:A,B,C',
            'images.*' => 'required|image|max:5120',
        ]);

        $client = new Client();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filePath = $file->getRealPath();

                $response = $client->post('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload', [
                    'auth' => [env('CLOUDINARY_API_KEY'), env('CLOUDINARY_API_SECRET')],
                    'multipart' => [
                        ['name' => 'file', 'contents' => fopen($filePath, 'r')],
                        ['name' => 'upload_preset', 'contents' => 'ml_default'],
                    ]
                ]);

                $data = json_decode($response->getBody(), true);

                Gallery::create([
                    'title' => $request->title,
                    'blok' => $request->blok,
                    'image_url' => $data['secure_url'],
                    'public_id' => $data['public_id'], // simpan public_id
                ]);
            }
        }

        event(new GalleryUpdated());
        return redirect()->route('admin.gallery.index')->with('success', 'Gambar berhasil diupload!');
    }

    // Form edit gallery
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    // Update gallery (replace gambar jika ada)
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'blok' => 'required|string|in:A,B,C',
            'image' => 'nullable|image|max:5120',
        ]);

        $client = new Client();

        if ($request->hasFile('image')) {
            // Hapus gambar lama di Cloudinary
            if ($gallery->public_id) {
                $client->delete('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/destroy', [
                    'auth' => [env('CLOUDINARY_API_KEY'), env('CLOUDINARY_API_SECRET')],
                    'form_params' => ['public_id' => $gallery->public_id]
                ]);
            }

            // Upload gambar baru
            $file = $request->file('image');
            $filePath = $file->getRealPath();

            $response = $client->post('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/upload', [
                'auth' => [env('CLOUDINARY_API_KEY'), env('CLOUDINARY_API_SECRET')],
                'multipart' => [
                    ['name' => 'file', 'contents' => fopen($filePath, 'r')],
                    ['name' => 'upload_preset', 'contents' => 'ml_default'],
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $gallery->image_url = $data['secure_url'];
            $gallery->public_id = $data['public_id'];
        }

        $gallery->title = $request->title;
        $gallery->blok = $request->blok;
        $gallery->save();

        event(new GalleryUpdated());
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery berhasil diupdate!');
    }

    // Hapus gallery
    public function destroy(Gallery $gallery)
    {
        $client = new Client();

        // Hapus gambar di Cloudinary
        if ($gallery->public_id) {
            $client->delete('https://api.cloudinary.com/v1_1/' . env('CLOUDINARY_CLOUD_NAME') . '/image/destroy', [
                'auth' => [env('CLOUDINARY_API_KEY'), env('CLOUDINARY_API_SECRET')],
                'form_params' => ['public_id' => $gallery->public_id]
            ]);
        }

        $gallery->delete();
        event(new GalleryUpdated());

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery berhasil dihapus!');
    }
}
