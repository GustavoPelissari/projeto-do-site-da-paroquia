<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$news = App\Models\News::where('title', 'LIKE', '%555%')->first();

if ($news) {
    echo "ID: " . $news->id . "\n";
    echo "Título: " . $news->title . "\n";
    echo "featured_image: " . ($news->featured_image ?? 'NULL') . "\n";
    echo "image: " . ($news->image ?? 'NULL') . "\n";
    echo "created_at: " . $news->created_at . "\n";
} else {
    echo "Notícia não encontrada\n";
    echo "Todas as notícias:\n";
    $all = App\Models\News::orderBy('id', 'desc')->take(5)->get();
    foreach ($all as $n) {
        echo "  - ID: {$n->id} | Título: {$n->title} | Data: {$n->created_at}\n";
    }
}
