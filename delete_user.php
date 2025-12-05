<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Delete user with specified email
$deleted = \App\Models\User::where('email', 'deigratiafotografia@gmail.com')->delete();

if ($deleted) {
    echo "✓ Usuário com email 'deigratiafotografia@gmail.com' foi deletado com sucesso.\n";
} else {
    echo "✗ Nenhum usuário encontrado com esse email.\n";
}
