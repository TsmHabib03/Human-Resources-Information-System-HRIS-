<?php
$publicRoot = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'public';
$sealCandidates = [
    '/assets/images/official-seal.svg' => $publicRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'official-seal.svg',
    '/assets/images/official-seal.png' => $publicRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'official-seal.png',
    '/assets/images/government-seal.svg' => $publicRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'government-seal.svg',
    '/assets/images/government-seal.png' => $publicRoot . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'government-seal.png',
];
$officialSealUrl = null;
foreach ($sealCandidates as $url => $candidatePath) {
    if (is_file($candidatePath)) {
        $officialSealUrl = $url;
        break;
    }
}
?>

<section class="login-scene">
    <div class="login-shell">
        <!-- ── Left: Premium Authority Panel ──────────────── -->
        <aside class="login-story" aria-hidden="true">
            <!-- Back to Home Button (Above Barangay HRIS) -->
            <a href="/" class="back-home-btn" style="display:flex;align-items:center;gap:0.5rem;padding:0.35rem 0.85rem;border-radius:0.375rem;background:#f3f4f6;color:#2563eb;font-weight:500;font-size:0.95rem;text-decoration:none;box-shadow:0 1px 4px 0 rgba(37,99,235,0.06);transition:background 0.2s;cursor:pointer;min-width:0;margin-bottom:0.75rem;">
                <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                <span style="font-size:0.95rem;">Home</span>
            </a>
            <div class="story-head">
                <div class="story-seal" aria-hidden="true">
                    <?php if ($officialSealUrl !== null): ?>
                        <img src="<?= e($officialSealUrl) ?>" alt="Seal" loading="lazy">
                    <?php else: ?>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <?php endif; ?>
                </div>
                <div class="story-brand">
                    <span class="story-badge">Official Portal</span>
                    <span class="story-system-name">Barangay HRIS</span>
                </div>
                <span class="story-status">Security Active</span>
            </div>

            <hr class="story-divider">

            <h1 class="story-headline">
                Workforce administration with operational clarity
            </h1>
            <p class="story-subtext">
                The consolidated command center for attendance, leave management, and employee records. Built for secure, data-driven barangay operations.
            </p>

            <div class="story-metrics">
                <article class="story-metric">
                    <p class="story-metric-value">Real-time</p>
                    <p class="story-metric-label">Attendance Tracking</p>
                </article>
                <article class="story-metric">
                    <p class="story-metric-value">Automated</p>
                    <p class="story-metric-label">Leave Workflows</p>
                </article>
                <article class="story-metric">
                    <p class="story-metric-value">Unified</p>
                    <p class="story-metric-label">Employee Portal</p>
                </article>
                <article class="story-metric">
                    <p class="story-metric-value">Military</p>
                    <p class="story-metric-label">Grade Encryption</p>
                </article>
            </div>

            <ul class="story-list">
                <li>Consolidated timesheet intelligence and auditing</li>
                <li>Digitalized leave request and approval routing</li>
                <li>Comprehensive personnel files and active records</li>
                <li>Fine-grained role-based access control (RBAC)</li>
            </ul>

            <p class="story-caption">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px; opacity:0.7;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                Authorized personnel only. Access attempt logs are active.
            </p>
        </aside>

        <!-- ── Right: Modern Sign-In Panel ────────────── -->
        <article class="login-panel">
<<<<<<< HEAD

           
            <div class="panel-head" style="position:relative;">
                <p class="panel-kicker">Secure Access</p>
                <h2 class="font-display text-3xl font-extrabold tracking-tight text-slate-900">Welcome back</h2>
                <p class="text-sm leading-relaxed text-slate-600">Sign in to continue to your dashboard.</p>
=======
            <div class="panel-head">
                <p class="panel-kicker">Secure Gateway</p>
                <h2 class="panel-title">Sign in to your account</h2>
                <p class="panel-subtext">Enter your credentials to manage workforce operations.</p>
>>>>>>> 96703a6 (Modern Teal with Navy blue color design Goverment modern style frontend changes)
            </div>

            <div class="panel-alerts"><?php require __DIR__ . '/../partials/alerts.php'; ?></div>

            <form method="post" action="/login" class="login-form" novalidate>
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

                <div class="login-field">
                    <span class="field-label">Username or Email</span>
                    <input
                        id="identity"
                        name="identity"
                        type="text"
                        required
                        autocomplete="username"
                        placeholder="e.g. j.delacruz"
                        spellcheck="false">
                </div>

                <div class="login-field">
                    <span class="field-label">Password</span>
                    <div class="password-wrap">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••">
                        <button
                            type="button"
                            class="password-toggle"
                            data-password-toggle
                            aria-controls="password"
                            aria-label="Show password">Show</button>
                    </div>
                </div>

<<<<<<< HEAD
                <button type="submit" class="login-submit">Sign in to dashboard</button>

=======
                <button type="submit" class="login-submit">
                    Sign in to Portal
                </button>
>>>>>>> 96703a6 (Modern Teal with Navy blue color design Goverment modern style frontend changes)
            </form>

            <div class="panel-foot">
                <p class="seed-note">
                    <strong>Testing Credentials:</strong><br>
                    User: <code>superadmin</code> / Pass: <code>Admin@123</code>
                </p>
                <div class="panel-meta">
                    <span>SSL Active</span>
                    <span>CSRF Valid</span>
                    <span>Audit On</span>
                </div>
                <div style="margin-top: 16px; text-align: center;">
                    <a href="/forgot-password" style="font-size: var(--text-xs); color: var(--blue-700); font-weight: 700; text-decoration: none;">Forgot your password?</a>
                </div>
            </div>

            <p class="login-legal">
                Property of Barangay Administrative Services. © <?= date('Y') ?>
            </p>
        </article>
    </div>
</section>

<script>
(function () {
    var toggle = document.querySelector('[data-password-toggle]');
    var input  = document.getElementById('password');
    if (!toggle || !input) return;
    toggle.addEventListener('click', function () {
        var next = input.type === 'password' ? 'text' : 'password';
        input.type = next;
        toggle.textContent = next === 'password' ? 'Show' : 'Hide';
        toggle.setAttribute('aria-label', next === 'password' ? 'Show password' : 'Hide password');
    });
})();
</script>
