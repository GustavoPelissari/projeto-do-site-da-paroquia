<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Find user by email and mark as verified
$email = 'deigratiafotografia@gmail.com';
$user = \App\Models\User::where('email', $email)->first();

if ($user) {
    if ($user->email_verified_at) {
        echo "✓ Usuário '{$user->name}' ({$email}) já está verificado desde: {$user->email_verified_at}\n";
    } else {
        $user->email_verified_at = now();
        $user->save();
        echo "✓ Usuário '{$user->name}' ({$email}) foi marcado como verificado com sucesso!\n";
    }
} else {
    echo "✗ Nenhum usuário encontrado com o email: {$email}\n";
}
