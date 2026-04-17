<?php
$statsData = is_array($stats ?? null) ? $stats : [];
$trendData = is_array($trend ?? null) ? $trend : ['labels' => [], 'values' => []];
$todayLabel = date('M d, Y', strtotime((string) ($today ?? date('Y-m-d'))));
$trendJson = json_encode($trendData, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
$roleLabel = (string) (($user['role_name'] ?? 'N/A'));

if (super_admin_only_mode_enabled()) {
    $roleLabel = is_super_admin_user($user)
        ? 'Super Admin (Single Actor Mode)'
        : 'Blocked Actor';
}

if ($trendJson === false) {
    $trendJson = '{"labels":[],"values":[]}';
}
?>

<section class="dashboard-v2">
    <header class="dash-hero">
        <div class="dash-hero-copy">
            <p class="hero-kicker">Daily Command Center</p>
            <h2 class="font-display text-3xl font-extrabold tracking-tight text-slate-900">Operational snapshot for <?= e($todayLabel) ?></h2>
            <p class="hero-subtext">Monitor staffing, unblock approvals, and move payroll actions from one focused view.</p>
            <div class="hero-tags">
                <span class="hero-tag hero-tag-blue">Attendance Live</span>
                <span class="hero-tag hero-tag-teal">Leave Workflow</span>
                <span class="hero-tag hero-tag-coral">Payroll Queue</span>
            </div>
        </div>
        <aside class="dash-hero-side">
            <p class="side-label">Signed in as</p>
            <p class="side-value"><?= e((string) (($user['username'] ?? 'Unknown'))) ?></p>
            <p class="side-meta">Role: <?= e($roleLabel) ?></p>
        </aside>
    </header>

    <section class="kpi-grid">
        <article class="kpi-card kpi-blue">
            <div class="kpi-head">
                <h3>Total Employees</h3>
                <span>Headcount</span>
            </div>
            <p class="kpi-value font-display"><?= e((string) ($statsData['totalEmployees'] ?? 0)) ?></p>
            <p class="kpi-note">All employee records in the system</p>
        </article>

        <article class="kpi-card kpi-teal">
            <div class="kpi-head">
                <h3>Present Today</h3>
                <span>Today</span>
            </div>
            <p class="kpi-value font-display"><?= e((string) ($statsData['presentToday'] ?? 0)) ?></p>
            <p class="kpi-note">Present, late, and half-day attendance</p>
        </article>

        <article class="kpi-card kpi-coral">
            <div class="kpi-head">
                <h3>Pending Leaves</h3>
                <span>For Review</span>
            </div>
            <p class="kpi-value font-display"><?= e((string) ($statsData['pendingLeaves'] ?? 0)) ?></p>
            <p class="kpi-note">Requests waiting for approval</p>
        </article>
    </section>

    <section class="dash-grid">
        <article class="panel trend-panel">
            <div class="panel-header">
                <div>
                    <p class="panel-kicker">Attendance Trend</p>
                    <h3>Last 7 days</h3>
                </div>
                <span class="panel-chip">Auto-updated</span>
            </div>
            <div class="chart-wrap">
                <canvas id="attendanceChart" height="120" aria-label="Attendance trend chart" role="img"></canvas>
            </div>
            <script id="attendanceTrendData" type="application/json"><?= $trendJson ?></script>
        </article>

        <aside class="side-panels">
            <article class="panel quick-panel">
                <div class="panel-header compact">
                    <div>
                        <p class="panel-kicker">Quick Actions</p>
                        <h3>Go to modules</h3>
                    </div>
                </div>
                <div class="quick-links">
                    <?php if (can('employees.view')): ?>
                        <a href="/employees">Manage employees</a>
                    <?php endif; ?>
                    <?php if (can('attendance.manage')): ?>
                        <a href="/attendance">Record attendance</a>
                    <?php elseif (can('attendance.view')): ?>
                        <a href="/attendance">View attendance</a>
                    <?php endif; ?>
                    <?php if (can('leave.approve')): ?>
                        <a href="/leave">Review leave requests</a>
                    <?php elseif (can('leave.view')): ?>
                        <a href="/leave">View leave requests</a>
                    <?php endif; ?>
                    <?php if (can('payroll.view')): ?>
                        <a href="/payroll">Open payroll module</a>
                    <?php endif; ?>
                </div>
            </article>

            <article class="panel account-panel">
                <p class="account-kicker">Account Context</p>
                <p class="account-line">User: <strong><?= e((string) (($user['username'] ?? 'Unknown'))) ?></strong></p>
                <p class="account-line">Role: <?= e($roleLabel) ?></p>
                <p class="account-line">Last refresh: <?= e($todayLabel) ?></p>
            </article>
        </aside>
    </section>
</section>
