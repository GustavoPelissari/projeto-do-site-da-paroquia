<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->boot();

use App\Models\User;
use App\Models\Group;

echo "=== VERIFICAÇÃO DO COORDENADOR ===\n";

$user = User::where('email', 'coord.coroinhas@paroquia.test')->first();

if ($user) {
    echo "User: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role->value}\n";
    echo "Group ID: " . ($user->group_id ?? 'NULL') . "\n";
    
    if ($user->group_id) {
        $group = Group::find($user->group_id);
        echo "Group Name: " . ($group ? $group->name : 'Group not found') . "\n";
    }
} else {
    echo "User not found!\n";
}

echo "\n=== GRUPOS DISPONÍVEIS ===\n";
$groups = Group::all();
foreach ($groups as $group) {
    echo "ID: {$group->id} - Name: {$group->name}\n";
}