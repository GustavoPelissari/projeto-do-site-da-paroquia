<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

use App\Models\User;

echo "========================================\n";
echo "           USUÁRIOS DO SISTEMA\n";
echo "========================================\n\n";

$users = User::all();

if ($users->count() == 0) {
    echo "❌ Nenhum usuário encontrado no sistema.\n\n";
} else {
    echo "📊 Total de usuários: " . $users->count() . "\n\n";
    
    foreach ($users as $index => $user) {
        echo "👤 USUÁRIO " . ($index + 1) . ":\n";
        echo "   ID: " . $user->id . "\n";
        echo "   Nome: " . $user->name . "\n";
        echo "   Email: " . $user->email . "\n";
        echo "   Role: " . $user->role . "\n";
        echo "   Verificado: " . ($user->email_verified_at ? "✅ Sim" : "❌ Não") . "\n";
        echo "   Criado em: " . $user->created_at->format('d/m/Y H:i:s') . "\n";
        echo "   Telefone: " . ($user->phone ?? "Não informado") . "\n";
        echo "   Grupo: " . ($user->parish_group_id ?? "Nenhum") . "\n";
        echo "----------------------------------------\n\n";
    }
}