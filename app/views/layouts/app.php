<?php

declare(strict_types=1);

$app = config('app');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Dashboard') . ' | ' . $app['name']) ?></title>
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/layout.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
</head>
<body>
    <div class="app-shell">
        <?php require __DIR__ . '/../partials/sidebar.php'; ?>

        <main class="app-main">
            <?php require __DIR__ . '/../partials/topbar.php'; ?>
            <section class="app-content">
                <?php require $contentView; ?>
            </section>
            <?php require __DIR__ . '/../partials/footer.php'; ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/js/dashboard.js"></script>
</body>
</html>
