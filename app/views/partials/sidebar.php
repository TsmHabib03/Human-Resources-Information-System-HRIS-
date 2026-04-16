<?php
$currentPath = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/');

$navItems = [
    ['path' => '/', 'label' => 'Dashboard', 'permission' => 'dashboard.view'],
    ['path' => '/employees', 'label' => 'Employees', 'permission' => 'employees.view'],
    ['path' => '/attendance', 'label' => 'Attendance', 'permission' => 'attendance.view'],
    ['path' => '/leave', 'label' => 'Leave', 'permission' => 'leave.view'],
    ['path' => '/payroll', 'label' => 'Payroll', 'permission' => 'payroll.view'],
    ['path' => '/settings', 'label' => 'Settings', 'permission' => 'settings.manage'],
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
            <?php if (!can((string) ($item['permission'] ?? ''))): ?>
                <?php continue; ?>
            <?php endif; ?>
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
