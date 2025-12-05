<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// List all users
$users = \App\Models\User::all();

echo "Usuários no banco de dados:\n";
echo "==========================\n";
foreach ($users as $user) {
    echo "- {$user->name} ({$user->email})\n";
}
echo "\nTotal: " . count($users) . " usuários\n";
