<?php

declare(strict_types=1);

$app = config('app');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Authentication') . ' | ' . $app['name']) ?></title>
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/components.css">
</head>
<body class="auth-page">
    <main class="auth-shell">
        <?php require $contentView; ?>
    </main>
</body>
</html>
