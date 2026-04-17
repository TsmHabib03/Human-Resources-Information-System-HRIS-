<?php

declare(strict_types=1);

use App\Core\Auth;

$app = config('app');
$authUser = Auth::user();
$todayLabel = date('M d, Y');
$roleLabel = (string) ($authUser['role_name'] ?? 'No role');

if (super_admin_only_mode_enabled()) {
    $roleLabel = is_super_admin_user($authUser)
        ? 'Super Admin (Single Actor Mode)'
        : 'Blocked Actor';
}
?>
<header class="topbar">
    <button class="sidebar-toggle topbar-menu-btn" id="sidebarToggle" aria-label="Toggle menu">Menu</button>

    <div class="topbar-meta">
        <p class="topbar-kicker">Workspace</p>
        <h1 class="font-display"><?= e($title ?? 'Dashboard') ?></h1>
        <p><?= e($app['name']) ?></p>
    </div>

    <div class="topbar-pill">
        <p class="topbar-user"><?= e((string) ($authUser['username'] ?? 'Unknown user')) ?></p>
        <p class="topbar-role"><?= e($roleLabel) ?></p>
        <p class="topbar-date"><?= e($todayLabel) ?></p>
    </div>
</header>
