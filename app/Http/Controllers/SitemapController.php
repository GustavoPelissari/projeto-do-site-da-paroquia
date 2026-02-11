<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = $this->generateSitemap();

        return response($sitemap, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    protected function generateSitemap(): string
    {
        $baseUrl = url('/');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Main pages
        $pages = [
            ['url' => '/', 'priority' => 1.0, 'changefreq' => 'daily'],
            ['url' => '/groups', 'priority' => 0.9, 'changefreq' => 'weekly'],
            ['url' => '/masses', 'priority' => 0.9, 'changefreq' => 'weekly'],
            ['url' => '/events', 'priority' => 0.9, 'changefreq' => 'daily'],
            ['url' => '/news', 'priority' => 0.9, 'changefreq' => 'daily'],
            ['url' => '/sobre', 'priority' => 0.8, 'changefreq' => 'monthly'],
        ];

        foreach ($pages as $page) {
            $xml .= $this->createUrlEntry(
                $baseUrl . $page['url'],
                now(),
                $page['changefreq'],
                $page['priority']
            );
        }

        // Dynamic events (last 7 days)
        $events = Event::where('status', 'published')
            ->where('date', '>=', now()->subDays(7))
            ->orderBy('date', 'asc')
            ->limit(1000)
            ->get();

        foreach ($events as $event) {
            $xml .= $this->createUrlEntry(
                route('events.show', $event),
                $event->updated_at,
                'weekly',
                0.7
            );
        }

        // Dynamic news
        $news = News::where('status', 'published')
            ->latest('published_at')
            ->limit(500)
            ->get();

        foreach ($news as $item) {
            $xml .= $this->createUrlEntry(
                route('news.show', $item),
                $item->updated_at,
                'monthly',
                0.6
            );
        }

        $xml .= '</urlset>';

        return $xml;
    }

    protected function createUrlEntry(
        string $loc,
        $lastmod = null,
        string $changefreq = 'monthly',
        float $priority = 0.5
    ): string {
        $entry = '  <url>' . "\n";
        $entry .= '    <loc>' . htmlspecialchars($loc, ENT_XML1, 'UTF-8') . '</loc>' . "\n";

        if ($lastmod) {
            try {
                $entry .= '    <lastmod>' . $lastmod->toAtomString() . '</lastmod>' . "\n";
            } catch (\Exception $e) {
                // Skip lastmod if there's an error
            }
        }

        $entry .= '    <changefreq>' . htmlspecialchars($changefreq, ENT_XML1, 'UTF-8') . '</changefreq>' . "\n";
        $entry .= '    <priority>' . number_format($priority, 1) . '</priority>' . "\n";
        $entry .= '  </url>' . "\n";

        return $entry;
    }
}

