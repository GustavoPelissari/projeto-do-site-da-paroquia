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
            'Cache-Control' => 'public, max-age=86400', // Cache for 24 hours
        ]);
    }

    protected function generateSitemap(): string
    {
        $baseUrl = url('/');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '         xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"' . "\n";
        $xml .= '         xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">' . "\n";

        // Main pages
        $pages = [
            ['url' => '/', 'priority' => 1.0, 'changefreq' => 'daily', 'lastmod' => now()],
            ['url' => '/groups', 'priority' => 0.9, 'changefreq' => 'weekly', 'lastmod' => now()],
            ['url' => '/masses', 'priority' => 0.9, 'changefreq' => 'weekly', 'lastmod' => now()],
            ['url' => '/events', 'priority' => 0.9, 'changefreq' => 'daily', 'lastmod' => now()],
            ['url' => '/news', 'priority' => 0.9, 'changefreq' => 'daily', 'lastmod' => now()],
            ['url' => '/sobre', 'priority' => 0.8, 'changefreq' => 'monthly', 'lastmod' => now()],
        ];

        foreach ($pages as $page) {
            $xml .= $this->createUrlEntry(
                $baseUrl . $page['url'],
                $page['lastmod'],
                $page['changefreq'],
                $page['priority']
            );
        }

        // Dynamic events
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
                0.6,
                $item->featured_image
            );
        }

        $xml .= '</urlset>';

        return $xml;
    }

    protected function createUrlEntry(
        string $loc,
        ?\DateTimeInterface $lastmod = null,
        string $changefreq = 'monthly',
        float $priority = 0.5,
        ?string $image = null
    ): string {
        $entry = '  <url>' . "\n";
        $entry .= '    <loc>' . htmlspecialchars($loc, ENT_XML1, 'UTF-8') . '</loc>' . "\n";

        if ($lastmod) {
            $entry .= '    <lastmod>' . $lastmod->toAtomString() . '</lastmod>' . "\n";
        }

        $entry .= '    <changefreq>' . htmlspecialchars($changefreq) . '</changefreq>' . "\n";
        $entry .= '    <priority>' . number_format($priority, 1) . '</priority>' . "\n";

        if ($image) {
            $entry .= '    <image:image>' . "\n";
            $entry .= '      <image:loc>' . htmlspecialchars(\Illuminate\Support\Facades\Storage::url($image), ENT_XML1, 'UTF-8') . '</image:loc>' . "\n";
            $entry .= '    </image:image>' . "\n";
        }

        $entry .= '  </url>' . "\n";

        return $entry;
    }
}
