<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Atualizar Capela Nossa Senhora de Fátima
$fatimaChapel = App\Models\Chapel::where('name', 'like', '%Fátima%')->first();
if ($fatimaChapel) {
    $fatimaChapel->address = 'R. Alfredo Bernardo, 4808-4860';
    $fatimaChapel->neighborhood = 'Primeiro de Maio';
    $fatimaChapel->city = 'Umuarama';
    $fatimaChapel->state = 'PR';
    $fatimaChapel->image = 'images/capela-fatima.jpg';
    $fatimaChapel->save();
    echo "✅ Capela Nossa Senhora de Fátima atualizada!\n";
    echo "   Endereço: R. Alfredo Bernardo, 4808-4860 - Primeiro de Maio, Umuarama - PR\n";
    echo "   Imagem: images/capela-fatima.jpg\n\n";
}

// Atualizar Capela Santo Antônio
$antonioChapel = App\Models\Chapel::where('name', 'like', '%Antônio%')->first();
if ($antonioChapel) {
    $antonioChapel->address = 'R. Santa Madalena';
    $antonioChapel->neighborhood = 'Jardim Shangrila';
    $antonioChapel->city = 'Umuarama';
    $antonioChapel->state = 'PR';
    $antonioChapel->image = 'images/capela-santo-antonio.jpg';
    $antonioChapel->save();
    echo "✅ Capela Santo Antônio atualizada!\n";
    echo "   Endereço: R. Santa Madalena - Jardim Shangrila, Umuarama - PR, 87509-090\n";
    echo "   Imagem: images/capela-santo-antonio.jpg\n\n";
}

echo "🎉 Todas as capelas foram atualizadas com sucesso!\n";
