<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== USUÁRIOS EXISTENTES ===\n";

$users = App\Models\User::all();

if ($users->count() === 0) {
    echo "Nenhum usuário encontrado no banco de dados.\n";
} else {
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Nome: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: {$user->role->value} ({$user->role->label()})\n";
        echo "Email Verificado: " . ($user->email_verified_at ? 'Sim' : 'Não') . "\n";
        echo "------------------------\n";
    }
}