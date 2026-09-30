<?php
/**
 * Returns the base_url for CodeIgniter, derived from the request.
 *
 * Why this exists: hardcoding base_url means the site only works on one hostname, so the
 * localhost:8082 value breaks when the site is reached through an ngrok tunnel (and vice
 * versa). Leaving base_url empty is NOT a fix -- CodeIgniter 3 then falls back to
 * $_SERVER['SERVER_ADDR'], which is the container's internal IP (e.g. 172.20.0.2), so every
 * CSS/JS/image URL points somewhere the browser cannot reach and the site renders unstyled.
 *
 * Deriving it from HTTP_HOST makes the same container serve correctly on localhost and
 * through a tunnel. X-Forwarded-Proto is honoured so ngrok's HTTPS front end does not end up
 * emitting http:// asset URLs on an https:// page (which browsers block as mixed content).
 *
 * This is a local-development convenience only; it is never copied to the host files.
 */

$isHttps = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
        && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');

$host = isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] !== ''
    ? $_SERVER['HTTP_HOST']
    : 'localhost:8082';

return ($isHttps ? 'https' : 'http') . '://' . $host . '/';
