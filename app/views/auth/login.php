<section class="login-scene">
    <span class="login-aura login-aura-one" aria-hidden="true"></span>
    <span class="login-aura login-aura-two" aria-hidden="true"></span>

    <div class="login-shell">
        <aside class="login-story" aria-hidden="true">
            <div class="story-head">
                <span class="story-badge">Barangay HRIS</span>
                <span class="story-status">Live operations</span>
            </div>

            <h1 class="font-display text-4xl font-extrabold tracking-tight text-slate-900">People operations, simplified.</h1>
            <p class="text-sm leading-relaxed text-slate-700">A modern command center for attendance, leave, payroll, and employee records.</p>

            <div class="story-metrics">
                <article class="story-metric">
                    <p class="story-metric-value">24/7</p>
                    <p class="story-metric-label">Portal uptime</p>
                </article>
                <article class="story-metric">
                    <p class="story-metric-value">One view</p>
                    <p class="story-metric-label">Unified workforce workflow</p>
                </article>
            </div>

            <ul class="story-list">
                <li>Track daily attendance in seconds</li>
                <li>Review leave requests without context switching</li>
                <li>Keep payroll and records aligned</li>
            </ul>

            <p class="story-caption">Designed for practical barangay HR workflows.</p>
        </aside>

        <article class="login-panel">
            <div class="panel-head">
                <p class="panel-kicker">Secure Access</p>
                <h2 class="font-display text-3xl font-extrabold tracking-tight text-slate-900">Welcome back</h2>
                <p class="text-sm leading-relaxed text-slate-600">Sign in to continue to your dashboard.</p>
            </div>

            <div class="panel-alerts"><?php require __DIR__ . '/../partials/alerts.php'; ?></div>

            <form method="post" action="/login" class="login-form" novalidate>
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

                <label class="login-field" for="identity">
                    <span class="field-label">Username or Email</span>
                    <input id="identity" name="identity" type="text" required autocomplete="username" placeholder="superadmin or admin@hris.local">
                </label>

                <label class="login-field" for="password">
                    <span class="field-label">Password</span>
                    <div class="password-wrap">
                        <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Enter your password">
                        <button type="button" class="password-toggle" data-password-toggle aria-controls="password" aria-label="Show password">Show</button>
                    </div>
                </label>

                <button type="submit" class="login-submit">Sign in to dashboard</button>
            </form>

            <div class="panel-foot">
                <p class="seed-note"><strong>Seeded account:</strong> superadmin / Admin@123</p>
                <div class="panel-meta">
                    <span>Encrypted session</span>
                    <span>CSRF protected form</span>
                    <span>Role-based access control</span>
                </div>
            </div>
        </article>
    </div>

    <p class="login-legal">Need account help? Contact your system administrator.</p>
</section>

<script>
    (function () {
        var toggle = document.querySelector('[data-password-toggle]');
        var input = document.getElementById('password');

        if (!toggle || !input) {
            return;
        }

        toggle.addEventListener('click', function () {
            var nextType = input.type === 'password' ? 'text' : 'password';
            input.type = nextType;
            toggle.textContent = nextType === 'password' ? 'Show' : 'Hide';
            toggle.setAttribute('aria-label', nextType === 'password' ? 'Show password' : 'Hide password');
        });
    })();
</script>
