<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use XMLWriter;

class SitemapController extends Controller
{
    private const POSTS_PER_SITEMAP = 1000;

    /**
     * GET /sitemap.xml (Sitemap index)
     */
    public function index(): Response
    {
        $entries = [
            [
                'loc' => route('sitemap.static'),
                'lastmod' => $this->resolveStaticLastModified(),
            ],
        ];

        foreach ($this->getBlogSitemapChunks() as $chunk) {
            $entries[] = [
                'loc' => route('sitemap.blog-posts', ['chunk' => $chunk['chunk']]),
                'lastmod' => $chunk['lastmod'],
            ];
        }

        return $this->xmlResponse($this->buildSitemapIndexXml($entries));
    }

    /**
     * GET /sitemaps/static.xml (Páginas públicas estáticas)
     */
    public function staticPages(): Response
    {
        $now = now()->toAtomString();

        $urls = [
            [
                'loc' => url('/'),
                'lastmod' => $now,
                'changefreq' => 'weekly',
                'priority' => '1.0',
            ],
            [
                'loc' => url('/blog'),
                'lastmod' => $this->resolveBlogLastModified(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => url('/privacidad'),
                'lastmod' => $now,
                'changefreq' => 'monthly',
                'priority' => '0.2',
            ],
            [
                'loc' => url('/terminos'),
                'lastmod' => $now,
                'changefreq' => 'monthly',
                'priority' => '0.2',
            ],
            [
                'loc' => url('/cookies'),
                'lastmod' => $now,
                'changefreq' => 'monthly',
                'priority' => '0.2',
            ],
        ];

        return $this->xmlResponse($this->buildUrlSetXml($urls));
    }

    /**
     * GET /sitemaps/blog-posts/{chunk}.xml (Chunk de posts indexables)
     */
    public function blogPosts(int $chunk): Response
    {
        $chunkInfo = collect($this->getBlogSitemapChunks())->firstWhere('chunk', $chunk);

        if (!$chunkInfo) {
            abort(404);
        }

        $posts = BlogPost::query()
            ->indexable()
            ->select(['id', 'slug', 'published_at', 'updated_at'])
            ->whereBetween('id', [$chunkInfo['from_id'], $chunkInfo['to_id']])
            ->orderBy('id')
            ->get();

        $urls = $posts->map(function (BlogPost $post): array {
            return [
                'loc' => route('blog.post', ['slug' => $post->slug]),
                'lastmod' => $this->formatLastModified($post->updated_at ?? $post->published_at),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        })->all();

        return $this->xmlResponse($this->buildUrlSetXml($urls));
    }

    /**
     * Construye la lista de chunks para sitemap de posts sin usar OFFSET.
     */
    private function getBlogSitemapChunks(): array
    {
        return cache()->remember(BlogPost::SITEMAP_CHUNKS_CACHE_KEY, now()->addMinutes(30), function () {
            $chunks = [];
            $chunkNumber = 1;

            BlogPost::query()
                ->indexable()
                ->select(['id', 'published_at', 'updated_at'])
                ->orderBy('id')
                ->chunkById(self::POSTS_PER_SITEMAP, function ($posts) use (&$chunks, &$chunkNumber) {
                    $first = $posts->first();
                    $last = $posts->last();

                    if (!$first || !$last) {
                        return;
                    }

                    $lastModified = $posts
                        ->map(fn (BlogPost $post) => $post->updated_at ?? $post->published_at)
                        ->filter()
                        ->max();

                    $chunks[] = [
                        'chunk' => $chunkNumber++,
                        'from_id' => (int) $first->id,
                        'to_id' => (int) $last->id,
                        'lastmod' => $this->formatLastModified($lastModified),
                    ];
                });

            return $chunks;
        });
    }

    private function resolveStaticLastModified(): string
    {
        return $this->resolveBlogLastModified();
    }

    private function resolveBlogLastModified(): string
    {
        $lastUpdatedAt = BlogPost::query()->indexable()->max('updated_at');
        $lastPublishedAt = BlogPost::query()->indexable()->max('published_at');

        return $this->formatLastModified($lastUpdatedAt ?: $lastPublishedAt);
    }

    private function formatLastModified(mixed $date): string
    {
        if (!$date) {
            return now()->toAtomString();
        }

        if ($date instanceof \DateTimeInterface) {
            return Carbon::instance($date)->toAtomString();
        }

        return Carbon::parse($date)->toAtomString();
    }

    private function buildSitemapIndexXml(array $entries): string
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->setIndent(true);
        $xml->startElement('sitemapindex');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($entries as $entry) {
            $xml->startElement('sitemap');
            $xml->writeElement('loc', $entry['loc']);
            $xml->writeElement('lastmod', $entry['lastmod']);
            $xml->endElement();
        }

        $xml->endElement();
        $xml->endDocument();

        return $xml->outputMemory();
    }

    private function buildUrlSetXml(array $urls): string
    {
        $xml = new XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->setIndent(true);
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($urls as $url) {
            $xml->startElement('url');
            $xml->writeElement('loc', $url['loc']);
            $xml->writeElement('lastmod', $url['lastmod']);

            if (!empty($url['changefreq'])) {
                $xml->writeElement('changefreq', $url['changefreq']);
            }

            if (!empty($url['priority'])) {
                $xml->writeElement('priority', $url['priority']);
            }

            $xml->endElement();
        }

        $xml->endElement();
        $xml->endDocument();

        return $xml->outputMemory();
    }

    private function xmlResponse(string $xml): Response
    {
        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=900, s-maxage=900');
    }
}
