<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PendingVerifyController extends Controller
{
    public function __invoke(Request $request, string $token): RedirectResponse
    {
        if (!$request->hasValidSignature()) {
            return redirect()->route('register')->withErrors([
                'verification' => 'Link de verificação inválido ou expirado.',
            ]);
        }

        $data = Cache::pull('pending_registration:'.$token);

        if (!$data) {
            return redirect()->route('register')->withErrors([
                'verification' => 'Link expirado ou já utilizado. Faça o cadastro novamente.',
            ]);
        }

        // Extra safety: prevent duplicates
        if (User::where('email', $data['email'])->exists()) {
            return redirect()->route('login')->with('status', 'E-mail já verificado. Faça login.');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'E-mail verificado com sucesso!');
    }
}
