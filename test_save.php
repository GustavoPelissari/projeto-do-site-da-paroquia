<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::find(25);
echo "Antes: {$user->email_verified_at}\n";

$user->email_verified_at = now();
$result = $user->save();

echo "Save result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";

$user->refresh();
echo "Depois: {$user->email_verified_at}\n";
