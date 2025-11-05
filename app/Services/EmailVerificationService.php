<?php

namespace App\Services;

use App\Mail\VerifyEmailCode;
use App\Models\EmailVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationService
{
    public const EXPIRATION_MINUTES = 15;
    public const RESEND_COOLDOWN_SECONDS = 120; // 2 minutes
    public const ATTEMPT_LIMIT = 5;

    /**
     * Generate and send a new verification code, respecting resend cooldown.
     * Returns array with status and optional retry_after seconds.
     */
    public function sendCode(User $user): array
    {
        $record = EmailVerification::firstOrNew(['user_id' => $user->id]);

        // Throttle resend
        if ($record->exists && $record->last_sent_at && $record->last_sent_at->diffInSeconds(now()) < self::RESEND_COOLDOWN_SECONDS) {
            $retry = self::RESEND_COOLDOWN_SECONDS - $record->last_sent_at->diffInSeconds(now());
            return ['status' => 'throttled', 'retry_after' => max($retry, 1)];
        }

        $code = $this->generateCode();
        $hash = Hash::make($code);

        // Log temporário para desenvolvimento (REMOVER EM PRODUÇÃO)
        Log::info("🔐 Código de verificação para {$user->email}: {$code}");

        // Upsert transactional to avoid race conditions
        DB::transaction(function () use ($user, $record, $hash) {
            $record->fill([
                'email' => $user->email,
                'code_hash' => $hash,
                'attempts' => 0,
                'expires_at' => now()->addMinutes(self::EXPIRATION_MINUTES),
                'last_sent_at' => now(),
            ]);
            $record->user()->associate($user);
            $record->save();
        });

        Mail::to($user->email)->queue(new VerifyEmailCode($user, $code, self::EXPIRATION_MINUTES));

        return ['status' => 'sent'];
    }

    /**
     * Validate a code, enforce expiry and attempts, and mark user verified on success.
     */
    public function verifyCode(User $user, string $code): array
    {
        $record = EmailVerification::where('user_id', $user->id)->first();
        if (!$record) {
            return ['ok' => false, 'reason' => 'missing'];
        }

        if ($record->attempts >= self::ATTEMPT_LIMIT) {
            return ['ok' => false, 'reason' => 'attempts_exceeded'];
        }

        if ($record->isExpired()) {
            return ['ok' => false, 'reason' => 'expired'];
        }

        // Hash check
        if (!Hash::check($code, $record->code_hash)) {
            $record->increment('attempts');
            return ['ok' => false, 'reason' => 'invalid', 'remaining' => max(self::ATTEMPT_LIMIT - $record->attempts, 0)];
        }

        // Success: mark verified and delete record
        DB::transaction(function () use ($user, $record) {
            $user->forceFill(['email_verified_at' => now()])->save();
            $record->delete();
        });

        return ['ok' => true];
    }

    /** Generate a 6-digit numeric code (zero-padded). */
    private function generateCode(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
