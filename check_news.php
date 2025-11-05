<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$news = App\Models\News::latest()->first();

if ($news) {
    echo "ID: " . $news->id . "\n";
    echo "Título: " . $news->title . "\n";
    echo "featured_image: " . ($news->featured_image ?? 'NULL') . "\n";
    echo "image: " . ($news->image ?? 'NULL') . "\n";
    echo "created_at: " . $news->created_at . "\n";
} else {
    echo "Nenhuma notícia encontrada\n";
}
