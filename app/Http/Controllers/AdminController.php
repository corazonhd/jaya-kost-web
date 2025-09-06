<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    private $url;
    private $key;

    public function __construct()
    {
        $this->url = env('SUPABASE_URL') . '/rest/v1';
        $this->key = env('SUPABASE_KEY');
    }

    private function fetchFromSupabase($table)
    {
        $response = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Accept' => 'application/json',
        ])->get("{$this->url}/{$table}", [
            'select' => '*',
            'order'  => 'id.asc',
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    public function users()
    {
        $users = $this->fetchFromSupabase('users');
        return view('admin.users', compact('users'));
    }

    public function bookings()
    {
        $bookings = $this->fetchFromSupabase('bookings');
        return view('admin.bookings', compact('bookings'));
    }

    public function messages()
    {
        $messages = $this->fetchFromSupabase('pesan');
        return view('admin.messages', compact('messages'));
    }

    public function dashboard()
    {
        $userCount = count($this->fetchFromSupabase('users'));
        $bookingCount = count($this->fetchFromSupabase('bookings'));
        $messagesCount = count($this->fetchFromSupabase('pesan'));

        return view('admin.dashboard', compact('userCount', 'bookingCount', 'messagesCount'));
    }

    public function deleteBooking($id)
    {
        $response = Http::withHeaders([
                'apikey' => $this->key,
                'Authorization' => 'Bearer ' . $this->key,
                'Accept' => 'application/json',
        ])->delete("{$this->url}/bookings?id=eq.{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.bookings')->with('success', 'Booking berhasil dihapus.');
        }

        return redirect()->route('admin.bookings')->with('error', 'Gagal menghapus booking.');
    }

    public function deleteUser($id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Accept' => 'application/json',
        ])->delete("{$this->url}/users?id=eq.{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
        }

        return redirect()->route('admin.users')->with('error', 'Gagal menghapus user.');
    }

    public function deleteMessage($id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->key,
            'Authorization' => 'Bearer ' . $this->key,
            'Accept' => 'application/json',
        ])->delete("{$this->url}/pesan?id=eq.{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.pesan')->with('success', 'Pesan berhasil dihapus.');
        }

        return redirect()->route('admin.pesan')->with('error', 'Gagal menghapus pesan.');
    }
}
