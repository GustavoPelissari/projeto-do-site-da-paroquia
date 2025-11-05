<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EmailVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function __construct(private EmailVerificationService $service) {}

    /** Show the numeric code form */
    public function showForm(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }
        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $throttle = null;
        // Hint: we don't send here; only display form and option to resend.
        return view('auth.verify-email', compact('throttle'));
    }

    /** Verify submitted code */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ], [
            'code.required' => 'Informe o código recebido por e-mail.',
            'code.digits' => 'O código deve ter exatamente 6 dígitos.',
        ]);

        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sessão expirada. Faça login novamente.');
        }

        // Already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'Seu e-mail já está verificado.');
        }

        $result = $this->service->verifyCode($user, $request->string('code'));
        if ($result['ok'] ?? false) {
            return redirect()->route('dashboard')->with('status', 'E-mail verificado com sucesso! Bem-vindo(a).');
        }

        // If attempts exceeded, suggest resend
        if (($result['reason'] ?? null) === 'attempts_exceeded') {
            return back()->withErrors([
                'code' => 'Limite de tentativas excedido. Por favor, solicite um novo código.',
            ])->withInput();
        }

        return back()->withErrors($this->mapError($result))->withInput();
    }

    /** Resend code with throttle */
    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sessão expirada. Faça login novamente.');
        }

        // Already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('status', 'Seu e-mail já está verificado.');
        }

        $status = $this->service->sendCode($user);
        if (($status['status'] ?? null) === 'throttled') {
            $seconds = (int) ($status['retry_after'] ?? 60);
            return back()->withErrors([
                'resend' => "Por favor, aguarde {$seconds} segundos antes de solicitar um novo código."
            ]);
        }

        return back()->with('status', 'Um novo código foi enviado para seu e-mail. Verifique sua caixa de entrada.');
    }

    private function mapError(array $result): array
    {
        $remaining = $result['remaining'] ?? 0;
        
        return match ($result['reason'] ?? null) {
            'missing' => ['code' => 'Nenhuma verificação pendente. Clique em "Reenviar código" para receber um novo.'],
            'attempts_exceeded' => ['code' => 'Você excedeu o limite de 5 tentativas. Solicite um novo código.'],
            'expired' => ['code' => 'Este código expirou (válido por 15 minutos). Solicite um novo código.'],
            'invalid' => ['code' => "Código incorreto. Você tem mais {$remaining} tentativa(s)."],
            default => ['code' => 'Não foi possível validar o código. Tente novamente.'],
        };
    }
}
