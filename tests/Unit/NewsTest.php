<?php

namespace Tests\Unit;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes unitários para o modelo News.
 */
class NewsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_published_returns_true_when_status_is_published(): void
    {
        $news = News::factory()->create(['status' => 'published']);
        $this->assertTrue($news->isPublished());
        $news->update(['status' => 'draft']);
        $this->assertFalse($news->fresh()->isPublished());
    }

    /** @test */
    public function excerpt_accessor_returns_value_or_generates_from_content(): void
    {
        $news = News::factory()->create([
            'excerpt' => null,
            'content' => str_repeat('Example content ', 10),
        ]);
        // Should generate excerpt from content
        $excerpt = $news->excerpt;
        $this->assertNotEmpty($excerpt);
        $this->assertIsString($excerpt);

        // When excerpt is provided, it should return it
        $news2 = News::factory()->create([
            'excerpt' => 'Custom summary',
            'content' => 'Some content',
        ]);
        $this->assertSame('Custom summary', $news2->excerpt);
    }
}