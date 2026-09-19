/**
 * Thikana Dhabla Ghosi — Cloudflare Worker
 * ----------------------------------------
 * Purpose:
 *   - Serve static assets
 *   - Redirect unknown URLs to the correct homepage
 *     (English → /index.html, Hindi → /hi/index.html)
 *   - Preserve proper 404 vs 301/302 status codes
 *   - Block obviously malicious paths
 */

export default {
  async fetch(request, env, ctx) {
    const url = new URL(request.url);
    const path = url.pathname;
    const method = request.method;

    // ─────────────────────────────────────────────
    // 1. Only handle GET and HEAD — reject others politely
    // ─────────────────────────────────────────────
    if (method !== 'GET' && method !== 'HEAD') {
      return new Response('Method Not Allowed', {
        status: 405,
        headers: { 'Allow': 'GET, HEAD' }
      });
    }

    // ─────────────────────────────────────────────
    // 2. Security: block weird traversal attempts early
    // ─────────────────────────────────────────────
    if (path.includes('..') || path.includes('//')) {
      return Response.redirect(new URL('/', url.origin), 302);
    }

    // ─────────────────────────────────────────────
    // 3. Try to serve the static asset
    // ─────────────────────────────────────────────
    let response;
    try {
      response = await env.ASSETS.fetch(request);
    } catch (err) {
      console.error('Asset fetch failed:', err);
      response = new Response('Internal Error', { status: 500 });
    }

    // ─────────────────────────────────────────────
    // 4. If found (200/304), return it directly
    // ─────────────────────────────────────────────
    if (response.status !== 404) {
      // Add cache + security headers to successful responses
      const headers = new Headers(response.headers);
      headers.set('X-Content-Type-Options', 'nosniff');
      headers.set('Referrer-Policy', 'strict-origin-when-cross-origin');
      headers.set('X-Frame-Options', 'SAMEORIGIN');

      return new Response(response.body, {
        status: response.status,
        statusText: response.statusText,
        headers
      });
    }

    // ─────────────────────────────────────────────
    // 5. 404 → decide redirect target based on path
    // ─────────────────────────────────────────────
    const isHindi =
      path === '/hi' ||
      path.startsWith('/hi/') ||
      path.startsWith('/hi?') ||
      path.startsWith('/hi#');

    const target = isHindi ? '/hi/index.html' : '/index.html';

    // Preserve query string (e.g. /555?ref=fb → /index.html?ref=fb)
    const redirectURL = new URL(target, url.origin);
    redirectURL.search = url.search;
    // Do NOT preserve hash — servers never see it anyway

    // ─────────────────────────────────────────────
    // 6. Special case: exact root paths should never 404
    // ─────────────────────────────────────────────
    if (path === '/' || path === '/index.html') {
      // Already handled above; kept as a safety net
      return Response.redirect(new URL('/index.html', url.origin), 302);
    }

    if (path === '/hi' || path === '/hi/') {
      return Response.redirect(new URL('/hi/index.html', url.origin), 302);
    }

    // ─────────────────────────────────────────────
    // 7. Final: redirect unknown paths to homepage
    // ─────────────────────────────────────────────
    console.log(`[404 → redirect] ${path} → ${target}`);
    return Response.redirect(redirectURL.toString(), 302);
  }
};
