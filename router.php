<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = __DIR__ . $uri;

// Serve existing files directly.
if ($uri !== '/' && file_exists($path) && !is_dir($path)) {
    return false;
}

// Rewrite /login/<ref> to login.php?path=<ref>
if (preg_match('#^/login/([a-zA-Z0-9_-]+)$#', $uri, $matches)) {
    $_GET['path'] = $matches[1];
    require __DIR__ . '/login.php';
    return true;
}

// Rewrite /sites/<id> to site.php?site_id=<id>
if (preg_match('#^/sites/(.+)$#', $uri, $matches)) {
    $_GET['site_id'] = $matches[1];
    require __DIR__ . '/site.php';
    return true;
}

// Rewrite pretty URLs without extension to .php files.
if (preg_match('#^/([^/.]+)$#', $uri, $matches)) {
    $file = __DIR__ . '/' . $matches[1] . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
}

// Fallback to server's default router.
return false;
