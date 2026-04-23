<?php
declare(strict_types=1);
$app = config('app');
$assetVersion = (string) max(
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/variables.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/base.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/components.css') ?: 1)
);
?>
<!doctype html>
<html lang="en" style="color-scheme: light;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Authentication') . ' | ' . $app['name']) ?></title>
    <meta name="theme-color" content="#0b3d91">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/variables.css?v=<?= e($assetVersion) ?>">
    <link rel="stylesheet" href="/assets/css/base.css?v=<?= e($assetVersion) ?>">
    <link rel="stylesheet" href="/assets/css/components.css?v=<?= e($assetVersion) ?>">
</head>
<body class="auth-page">
    <div class="auth-banner" role="region" aria-label="Official notice">
        <span class="auth-banner-left">
            <svg class="auth-banner-seal" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="8" cy="8" r="7.2" fill="#b68409"/>
                <path d="M8 3.5 L9 6.2 L11.8 6.2 L9.6 8 L10.4 10.8 L8 9.1 L5.6 10.8 L6.4 8 L4.2 6.2 L7 6.2 Z" fill="#ffffff"/>
            </svg>
            <span>An official Human Resources Information System</span>
        </span>
        <span class="auth-banner-right">Secure &middot; CSRF Protected</span>
    </div>
    <main class="auth-shell">
        <?php require $contentView; ?>
    </main>
    <footer class="auth-footer">
        <strong>Barangay HRIS</strong> &middot; Official Government Portal &middot; &copy; <?= e(date('Y')) ?>
    </footer>
</body>
</html>
