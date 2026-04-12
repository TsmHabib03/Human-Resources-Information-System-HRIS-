<?php
$currentPath = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/');

$navItems = [
    ['path' => '/', 'label' => 'Dashboard'],
    ['path' => '/employees', 'label' => 'Employees'],
    ['path' => '/attendance', 'label' => 'Attendance'],
    ['path' => '/leave', 'label' => 'Leave'],
    ['path' => '/payroll', 'label' => 'Payroll'],
    ['path' => '/settings', 'label' => 'Settings'],
];
?>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <span class="brand-dot"></span>
        <div class="brand-meta">
            <span class="font-display">Barangay HRIS</span>
            <span>Management Portal</span>
        </div>
    </div>

    <p class="sidebar-label">Navigation</p>

    <nav class="sidebar-nav">
        <?php foreach ($navItems as $item): ?>
            <?php
            $isRoot = $item['path'] === '/';
            $isActive = $isRoot ? $currentPath === '/' : str_starts_with($currentPath, $item['path']);
            ?>
            <a
                class="nav-link<?= $isActive ? ' is-active' : '' ?>"
                href="<?= e($item['path']) ?>"
                <?= $isActive ? 'aria-current="page"' : '' ?>
            >
                <span class="nav-link-dot" aria-hidden="true"></span>
                <span><?= e($item['label']) ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <a class="nav-link logout" href="/logout">
        <span class="nav-link-dot" aria-hidden="true"></span>
        <span>Sign out</span>
    </a>
</aside>
