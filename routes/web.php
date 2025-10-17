<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KamarStatusController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\GalleryController as PublicGalleryController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Models\User;
use App\Models\Booking;
use App\Models\KamarStatus;
use App\Models\Pesan;

// =====================
// Frontend
// =====================
Route::get('/', fn() => view('index'))->name('home');
Route::get('/about', [AboutController::class, 'show'])->name('about');
Route::get('/gallery', [PublicGalleryController::class, 'index'])->name('gallery');
Route::get('/book', fn() => view('book'))->name('book');

// =====================
// Form pertanyaan
// =====================
Route::post('/save-message', [FormController::class, 'saveMessage'])->name('save-message');

// =====================
// Kamar status
// =====================
Route::get('/api/kamar-status', [KamarController::class, 'getKamarStatus'])->name('get_room_status');

// =====================
// Booking
// =====================
Route::post('/process-booking', [BookingController::class, 'processBooking'])->name('process_booking');
Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
Route::post('/xendit/webhook', [XenditWebhookController::class, 'handleWebhook']);

// =====================
// User yang sudah login
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =================
// Bagian Admin 
// =================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('dashboard', [
            'userCount'      => User::count(),
            'bookingCount'   => Booking::count(),
            'availableKamar' => KamarStatus::where('status', 'Available')->count(),
            'messagesCount'  => Pesan::count(),
        ]);
    })->name('dashboard');

    // Navigasi UPP
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/pemesanan', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/pesan', [AdminController::class, 'messages'])->name('admin.pesan');

    // Delete UPP
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');
    Route::delete('/pemesanan/{id}', [AdminController::class, 'deleteBooking'])->name('admin.bookings.destroy');
    Route::delete('/pesan/{id}', [AdminController::class, 'deleteMessage'])->name('admin.pesan.destroy');

    // Galeri CRUD
    Route::get('/galeri', [AdminGalleryController::class, 'index'])->name('admin.gallery.index');
    Route::get('/galeri/create', [AdminGalleryController::class, 'create'])->name('admin.gallery.create');
    Route::post('/galeri', [AdminGalleryController::class, 'store'])->name('admin.gallery.store');
    Route::get('/galeri/{gallery}/edit', [AdminGalleryController::class, 'edit'])->name('admin.gallery.edit');
    Route::put('/galeri/{gallery}', [AdminGalleryController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/galeri/{gallery}', [AdminGalleryController::class, 'destroy'])->name('admin.gallery.destroy');

    // Rute API Galeri
    Route::get('/api/gallery', [AdminGalleryController::class, 'apiIndex'])->name('admin.gallery.api');

    // Rute Profile
    Route::get('/profil', [TentangController::class, 'edit'])->name('admin.profile');
    Route::post('/profil/update', [TentangController::class, 'update'])->name('admin.profile.update');

    // Rute Kamar Status
    Route::get('/statuskamar', [KamarStatusController::class, 'index'])->name('admin.kamarstatus');
    Route::post('/statuskamar/{nama_kamar}', [KamarStatusController::class, 'update'])->name('admin.kamarstatus.update');
});

require __DIR__.'/auth.php';