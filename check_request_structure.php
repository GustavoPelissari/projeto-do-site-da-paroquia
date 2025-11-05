<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$req = App\Models\GroupRequest::first();
if($req) {
    echo "Estrutura da GroupRequest:\n";
    echo json_encode($req->toArray(), JSON_PRETTY_PRINT);
} else {
    echo 'Nenhuma solicitação encontrada';
}
