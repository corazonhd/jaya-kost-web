<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use GuzzleHttp\Client;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input termasuk file KTP dan phone
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ktp' => ['required', 'file', 'image', 'max:2048'],
            'role' => ['sometimes', 'string', 'in:user,admin'],
        ]);

        $ktpUrl = null;

        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $client = new Client();
            $cloudName = env('CLOUDINARY_CLOUD_NAME');

            $response = $client->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($file->getRealPath(), 'r'),
                    ],
                    [
                        'name'     => 'upload_preset',
                        'contents' => 'ktp_users',
                    ],
                ],
            ]);

            $body = json_decode($response->getBody(), true);
            $ktpUrl = $body['secure_url'];

        }


        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', 
            'ktp_url' => $ktpUrl,             
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('home');
    }
}
