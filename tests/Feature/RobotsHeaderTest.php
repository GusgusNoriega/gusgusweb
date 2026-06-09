<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RobotsHeaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_responses_are_not_marked_noindex(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertSee('<sitemapindex', false);

        $this->get('/sitemaps/static.xml')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertSee('<urlset', false);
    }

    public function test_public_marketing_pages_are_not_marked_noindex_by_header(): void
    {
        $this->get('/blog')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag');
    }

    public function test_blog_post_sitemap_and_post_pages_are_not_marked_noindex_by_header(): void
    {
        BlogPost::query()->create([
            'title' => 'Sitemap test post',
            'slug' => 'sitemap-test-post',
            'content' => '<p>Test content</p>',
            'is_published' => true,
            'published_at' => now()->subDay(),
            'no_index' => false,
        ]);

        $this->get('/sitemaps/blog-posts/1.xml')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertSee('/blog/sitemap-test-post', false);

        $this->get('/blog/sitemap-test-post')
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag');
    }

    public function test_internal_routes_still_emit_noindex_header(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
