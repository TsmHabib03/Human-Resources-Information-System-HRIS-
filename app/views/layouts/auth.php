<?php

declare(strict_types=1);

$app = config('app');
$assetVersion = (string) (filemtime(__DIR__ . '/../../../public/assets/css/base.css') ?: 1);
?>
<!doctype html>
<html lang="en" style="color-scheme: light;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Authentication') . ' | ' . $app['name']) ?></title>
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
    <link rel="stylesheet" href="<?= e(asset_url('/assets/css/components.css') . '?v=' . rawurlencode($assetVersion)) ?>">
</head>
<body class="auth-page font-sans bg-slate-50 text-slate-900">
    <main class="auth-shell">
        <?php require $contentView; ?>
    </main>
</body>
</html>
