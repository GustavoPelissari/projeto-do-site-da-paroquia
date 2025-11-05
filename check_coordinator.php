<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Buscar grupo Coroinhas
$group = App\Models\Group::where('name', 'like', '%coroinha%')->first();

if ($group) {
    echo "Grupo encontrado: {$group->name}\n";
    echo "Coordinator ID: " . ($group->coordinator_id ?? 'NULL') . "\n";
    
    if ($group->coordinator_id) {
        $coordinator = App\Models\User::find($group->coordinator_id);
        if ($coordinator) {
            echo "Coordenador: {$coordinator->name}\n";
            echo "Email: {$coordinator->email}\n";
        } else {
            echo "ERRO: Coordinator ID definido mas usuário não encontrado!\n";
        }
    } else {
        echo "PROBLEMA: Grupo não tem coordinator_id definido!\n";
    }
} else {
    echo "Grupo Coroinhas não encontrado!\n";
}

// Verificar solicitações pendentes
echo "\n--- Solicitações Pendentes ---\n";
$requests = App\Models\GroupRequest::where('status', 'pending')->with(['user', 'group'])->get();
foreach ($requests as $req) {
    echo "ID: {$req->id} - {$req->user->name} -> {$req->group->name} (Status: {$req->status})\n";
}

// Verificar notificações do coordenador
echo "\n--- Notificações do Coordenador ---\n";
$coordEmail = 'coord.coroinhas@paroquia.test';
$coord = App\Models\User::where('email', $coordEmail)->first();
if ($coord) {
    echo "Coordenador: {$coord->name} (ID: {$coord->id})\n";
    $notifications = App\Models\Notification::where('user_id', $coord->id)->get();
    echo "Total de notificações: " . $notifications->count() . "\n";
    foreach ($notifications as $notif) {
        echo "  - {$notif->title}: {$notif->message} (Lida: " . ($notif->read_at ? 'Sim' : 'Não') . ")\n";
    }
}
