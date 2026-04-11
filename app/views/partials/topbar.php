<?php $app = config('app'); ?>
<header class="topbar">
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle menu">Menu</button>
    <div class="topbar-meta">
        <h1><?= e($title ?? 'Dashboard') ?></h1>
        <p><?= e($app['name']) ?></p>
    </div>
</header>
