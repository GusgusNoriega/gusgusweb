<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoIndexUnlessHome
{
    private const INDEXABLE_ROUTE_NAMES = [
        'home',
        'blog',
        'blog.post',
        'privacidad',
        'terminos',
        'cookies',
    ];

    private const SEO_ROUTE_NAMES = [
        'sitemap',
        'sitemap.static',
        'sitemap.blog-posts',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $route = $request->route();
        $routeName = $route?->getName();
        $path = '/'.ltrim($request->path(), '/');

        if ($this->isSeoResource($routeName, $path) || $this->isIndexablePublicRoute($routeName, $path)) {
            $response->headers->remove('X-Robots-Tag');
            return $response;
        }

        // Internal and utility routes should not appear in search results.
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }

    private function isSeoResource(?string $routeName, string $path): bool
    {
        return in_array($routeName, self::SEO_ROUTE_NAMES, true)
            || $path === '/sitemap.xml'
            || $path === '/robots.txt'
            || str_starts_with($path, '/sitemaps/');
    }

    private function isIndexablePublicRoute(?string $routeName, string $path): bool
    {
        return $path === '/'
            || in_array($routeName, self::INDEXABLE_ROUTE_NAMES, true);
    }
}
