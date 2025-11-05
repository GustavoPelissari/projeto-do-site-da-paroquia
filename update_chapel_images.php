<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Atualizar Capela Nossa Senhora de Fátima
$fatimaChapel = App\Models\Chapel::where('name', 'like', '%Fátima%')->first();
if ($fatimaChapel) {
    $fatimaChapel->image = 'images/Capela Nossa Senhora de Fatima.png';
    $fatimaChapel->save();
    echo "✅ Capela Nossa Senhora de Fátima - imagem atualizada!\n";
    echo "   Imagem: images/Capela Nossa Senhora de Fatima.png\n\n";
}

// Atualizar Capela Santo Antônio
$antonioChapel = App\Models\Chapel::where('name', 'like', '%Antônio%')->first();
if ($antonioChapel) {
    $antonioChapel->image = 'images/capela-santo-antonio.jpg';
    $antonioChapel->save();
    echo "✅ Capela Santo Antônio - imagem atualizada!\n";
    echo "   Imagem: images/capela-santo-antonio.jpg\n\n";
}

echo "🎉 Imagens das capelas atualizadas com sucesso!\n";
