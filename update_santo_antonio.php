<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Atualizar Capela Santo Antônio
$antonioChapel = App\Models\Chapel::where('name', 'like', '%Antônio%')->first();
if ($antonioChapel) {
    $antonioChapel->image = 'images/capela-santo-antonio.png';
    $antonioChapel->save();
    echo "✅ Capela Santo Antônio - imagem atualizada!\n";
    echo "   Imagem: images/capela-santo-antonio.png\n\n";
}

echo "🎉 Imagem da Capela Santo Antônio atualizada!\n";
