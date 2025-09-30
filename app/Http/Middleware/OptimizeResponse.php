<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Hanya untuk response HTML
        if ($response->headers->get('Content-Type') === 'text/html; charset=UTF-8') {
            $content = $response->getContent();

            // Minify HTML (remove extra whitespace, newlines, comments)
            $content = $this->minifyHtml($content);

            // Set content yang sudah diminify
            $response->setContent($content);
        }

        // Add cache headers untuk static assets
        if ($request->is('build/*') || $request->is('storage/*')) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000'); // 1 year
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
        }

        // Add security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Enable GZIP compression if supported
        if (str_contains($request->header('Accept-Encoding', ''), 'gzip')) {
            if (function_exists('gzencode')) {
                $content = $response->getContent();
                $compressed = gzencode($content);

                if ($compressed !== false && strlen($compressed) < strlen($content)) {
                    $response->setContent($compressed);
                    $response->headers->set('Content-Encoding', 'gzip');
                    $response->headers->set('Content-Length', strlen($compressed));
                }
            }
        }

        return $response;
    }

    /**
     * Minify HTML content
     */
    private function minifyHtml($html)
    {
        // Remove HTML comments (except IE conditionals)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);

        // Remove extra whitespace
        $html = preg_replace('/\s+/', ' ', $html);

        // Remove whitespace around tags
        $html = preg_replace('/>\s+</', '><', $html);

        // Remove whitespace at the beginning and end
        $html = trim($html);

        return $html;
    }
}
