<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        try {
            $userId = $request->route('id');
            $user = User::findOrFail($userId);
            
            // Check if already verified
            if ($user->hasVerifiedEmail()) {
                Auth::login($user);
                return redirect()->route('profile.edit')
                    ->with('success', 'Seu e-mail já está verificado!');
            }
            
            // Mark as verified
            $user->email_verified_at = now();
            $user->save();

            event(new Verified($user));
            Auth::login($user);

            return redirect()->route('profile.edit')
                ->with('success', '✓ E-mail verificado com sucesso! Agora você pode participar de grupos.');
            
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erro ao verificar e-mail: ' . $e->getMessage());
        }
    }
}
