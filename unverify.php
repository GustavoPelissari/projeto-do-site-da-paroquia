<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::find(25);
$user->email_verified_at = null;
$user->save();
echo "✓ Email desmarcado. Agora pode testar a verificação novamente.\n";
