<?php

namespace App\Services;

use App\Models\Event;
use App\Models\News;

/**
 * Structured Data Service
 * Generates JSON-LD for better search engine understanding
 */
class StructuredDataService
{
    /**
     * Generate Organization schema
     */
    public static function organization(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Paróquia São Paulo Apóstolo',
            'url' => config('app.url'),
            'logo' => asset('images/sao-paulo-logo.png'),
            'description' => 'Paróquia católica em Umuarama, Diocese de Umuarama',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Rua São Paulo, 123',
                'addressLocality' => 'Umuarama',
                'addressRegion' => 'PR',
                'postalCode' => '87501-000',
                'addressCountry' => 'BR',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Information',
                'telephone' => '+55-44-3622-2000',
            ],
        ];

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate Event schema
     */
    public static function event(Event $event): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->title,
            'description' => $event->description,
            'startDate' => $event->date->toIso8601String(),
            'url' => route('events.show', $event),
            'organizer' => [
                '@type' => 'Organization',
                'name' => 'Paróquia São Paulo Apóstolo',
            ],
        ];

        if ($event->image) {
            $schema['image'] = asset('storage/' . $event->image);
        }

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate Article schema for news
     */
    public static function article(News $news): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $news->title,
            'description' => $news->summary ?? substr(strip_tags($news->content), 0, 160),
            'datePublished' => $news->published_at->toIso8601String(),
            'dateModified' => $news->updated_at->toIso8601String(),
            'url' => route('news.show', $news),
            'author' => [
                '@type' => 'Organization',
                'name' => 'Paróquia São Paulo Apóstolo',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Paróquia São Paulo Apóstolo',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/sao-paulo-logo.png'),
                ],
            ],
        ];

        if ($news->featured_image) {
            $schema['image'] = [
                '@type' => 'ImageObject',
                'url' => \Illuminate\Support\Facades\Storage::url($news->featured_image),
            ];
        }

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate BreadcrumbList schema
     */
    public static function breadcrumbs(array $items): string
    {
        $itemListElement = [];

        foreach ($items as $position => $item) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement,
        ];

        return json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
