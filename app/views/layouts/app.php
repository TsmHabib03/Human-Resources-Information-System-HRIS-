<?php

declare(strict_types=1);

$app = config('app');
$assetVersion = (string) max(
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/base.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/layout.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/components.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/dashboard.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/attendance.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/leave.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/payroll.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/settings.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/billing.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/responsive.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/css/employees.css') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/js/app.js') ?: 1),
    (int) (filemtime(__DIR__ . '/../../../public/assets/js/dashboard.js') ?: 1)
);
?>
<!doctype html>
<html lang="en" style="color-scheme: light;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Dashboard') . ' | ' . $app['name']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <script>
        (function () {
            var root = document.documentElement;
            root.classList.remove('dark');
            root.style.colorScheme = 'light';
        })();

        tailwind = {
            config: {
                darkMode: 'class',
                corePlugins: {
                    preflight: false
                },
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Manrope', 'Segoe UI', 'Tahoma', 'sans-serif'],
                            display: ['Plus Jakarta Sans', 'Manrope', 'sans-serif']
                        },
                        colors: {
                            brand: {
                                50: '#eff6ff',
                                100: '#dbeafe',
                                500: '#2563eb',
                                600: '#1d4ed8',
                                700: '#1e40af'
                            },
                            teal: {
                                100: '#ccfbf1',
                                500: '#14b8a6',
                                700: '#0f766e'
                            },
                            coral: {
                                100: '#ffe3d5',
                                500: '#ff7a59',
                                700: '#e5562f'
                            }
                        },
                        boxShadow: {
                            soft: '0 10px 30px rgba(15, 23, 42, 0.08)'
                        }
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/variables.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/base.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/layout.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/components.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/dashboard.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/attendance.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/leave.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/payroll.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/settings.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/billing.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/employees.css') . '?v=' . rawurlencode($assetVersion)) ?>">
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/responsive.css') . '?v=' . rawurlencode($assetVersion)) ?>">
</head>
<body class="font-sans bg-slate-50 text-slate-900">
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
    <script src="<?= e(asset_url('/assets/js/app.js') . '?v=' . rawurlencode($assetVersion)) ?>"></script>
    <script src="<?= e(asset_url('/assets/js/dashboard.js') . '?v=' . rawurlencode($assetVersion)) ?>"></script>
</body>
</html>
