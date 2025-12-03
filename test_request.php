<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Group;
use App\Models\GroupRequest;

// Maria fazendo solicitação para Coroinhas
$maria = User::where('email', 'maria@paroquia.test')->first();
$coroinhas = Group::where('name', 'Coroinhas')->first();

if (!$maria) {
    die("Maria não encontrada!\n");
}

if (!$coroinhas) {
    die("Grupo Coroinhas não encontrado!\n");
}

echo "Maria ID: {$maria->id}\n";
echo "Coroinhas ID: {$coroinhas->id}\n";
echo "Maria grupo atual: " . ($maria->parish_group_id ?? 'nenhum') . "\n\n";

// Verificar se já existe solicitação
$existing = GroupRequest::where('user_id', $maria->id)
    ->where('group_id', $coroinhas->id)
    ->first();

if ($existing) {
    echo "Já existe solicitação!\n";
    echo "Status: {$existing->status}\n";
    exit;
}

// Criar solicitação
$request = GroupRequest::create([
    'user_id' => $maria->id,
    'group_id' => $coroinhas->id,
    'status' => 'pending',
    'message' => 'Gostaria de participar do grupo de Coroinhas',
]);

echo "✅ Solicitação criada com sucesso!\n";
echo "ID: {$request->id}\n";
echo "Status: {$request->status}\n";

// Notificar coordenador
$coordinator = User::where('email', 'coord.coroinhas@paroquia.test')->first();
\App\Models\Notification::create([
    'user_id' => $coordinator->id,
    'type' => 'group_request_received',
    'title' => 'Nova Solicitação de Ingresso',
    'message' => "{$maria->name} solicitou participar do grupo {$coroinhas->name}",
    'read_at' => null,
]);

echo "✅ Notificação enviada ao coordenador!\n";
