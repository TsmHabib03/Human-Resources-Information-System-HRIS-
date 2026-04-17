<?php
$currentPath = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/');
$authUser = auth_user();
$lockModalEnabled = subscription_lock_modal_enabled();

$navItems = [
    ['path' => '/dashboard', 'label' => 'Dashboard', 'permission' => 'dashboard.view'],
    ['path' => '/billing', 'label' => 'Billing', 'permission' => ''],
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
            <?php $permission = (string) ($item['permission'] ?? ''); ?>
            <?php if ($permission !== '' && !can($permission)): ?>
                <?php continue; ?>
            <?php endif; ?>
            <?php
            $path = (string) ($item['path'] ?? '/');
            $lockContext = nav_feature_lock_context($path, $authUser);
            $isLocked = $lockModalEnabled && (bool) ($lockContext['is_locked'] ?? false);
            $isActive = !$isLocked && str_starts_with($currentPath, $path);
            $linkHref = $isLocked ? '/billing' : $path;
            ?>
            <a
                class="nav-link<?= $isActive ? ' is-active' : '' ?><?= $isLocked ? ' is-locked' : '' ?>"
                href="<?= e($linkHref) ?>"
                <?= $isActive ? 'aria-current="page"' : '' ?>
                <?= $isLocked ? 'aria-disabled="true"' : '' ?>
                <?= $isLocked ? 'data-lock-trigger="1"' : '' ?>
                <?= $isLocked ? 'data-lock-feature-label="' . e((string) ($lockContext['feature_label'] ?? 'This module')) . '"' : '' ?>
                <?= $isLocked ? 'data-lock-plan-name="' . e((string) ($lockContext['plan_name'] ?? '')) . '"' : '' ?>
                <?= $isLocked ? 'data-lock-message="' . e((string) ($lockContext['message'] ?? 'Upgrade your plan in Billing to unlock this module.')) . '"' : '' ?>
            >
                <span class="nav-link-dot" aria-hidden="true"></span>
                <span><?= e($item['label']) ?></span>
                <?php if ($isLocked): ?>
                    <span class="nav-lock-chip">Locked</span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <a class="nav-link logout" href="/logout">
        <span class="nav-link-dot" aria-hidden="true"></span>
        <span>Sign out</span>
    </a>
</aside>
