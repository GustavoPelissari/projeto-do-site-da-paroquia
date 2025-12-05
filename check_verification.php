<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check verification status
$user = \App\Models\User::where('email', 'deigratiafotografia@gmail.com')->first();

if ($user) {
    echo "Usuário: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Verificado em: " . ($user->email_verified_at ? $user->email_verified_at : "NÃO VERIFICADO") . "\n";
    echo "ID: {$user->id}\n";
} else {
    echo "Usuário não encontrado.\n";
}
