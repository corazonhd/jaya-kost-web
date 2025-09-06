<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\XenditWebhookController;

// Primary webhook endpoint
Route::post('/xendit/callback', [XenditWebhookController::class, 'handle']);