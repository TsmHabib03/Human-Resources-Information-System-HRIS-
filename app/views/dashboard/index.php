<section class="bento-grid">
    <article class="widget widget-stat">
        <h2>Total Employees</h2>
        <p class="stat-number">0</p>
    </article>

    <article class="widget widget-stat">
        <h2>Present Today</h2>
        <p class="stat-number">0</p>
    </article>

    <article class="widget widget-stat">
        <h2>Pending Leaves</h2>
        <p class="stat-number">0</p>
    </article>

    <article class="widget widget-chart">
        <h2>Attendance Trend</h2>
        <canvas id="attendanceChart" height="120"></canvas>
    </article>

    <article class="widget widget-activity">
        <h2>Account</h2>
        <p>Signed in as <?= e((string) (($user['username'] ?? 'Unknown'))) ?></p>
        <p>Role: <?= e((string) (($user['role_name'] ?? 'N/A'))) ?></p>
    </article>
</section>
