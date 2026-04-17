<?php
$planRows = is_array($plans ?? null) ? $plans : [];
$hasPlans = $planRows !== [];

$comparisonRows = [
    'employees' => 'Employee management',
    'attendance' => 'Attendance tracking',
    'leave' => 'Leave workflows',
    'payroll' => 'Payroll setup',
    'settings' => 'Settings administration',
    'priority_support' => 'Priority support',
];

$planFeatures = [];
foreach ($planRows as $plan) {
    $decoded = json_decode((string) ($plan['feature_flags'] ?? '[]'), true);
    $planFeatures[(int) ($plan['id'] ?? 0)] = is_array($decoded) ? $decoded : [];
}
?>

<div class="mk-shell">
    <header class="mk-topbar" data-reveal style="--mk-delay: 0s;">
        <a class="mk-brand" href="/">
            <span class="mk-brand-dot" aria-hidden="true"></span>
            <span>
                <strong class="font-display">HRIS Cloud</strong>
                <small>Quarterly Subscription</small>
            </span>
        </a>

        <nav class="mk-nav" aria-label="Main navigation">
            <a href="/pricing">Pricing</a>
            <a href="/login" class="mk-login-link">Sign in</a>
        </nav>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="mk-hero" aria-labelledby="mk-hero-title">
        <div class="mk-hero-main" data-reveal style="--mk-delay: .06s;">
            <p class="mk-kicker">HR SaaS Platform</p>
            <h1 id="mk-hero-title" class="font-display">Run HR like an operating system, not a spreadsheet ritual.</h1>
            <p class="mk-hero-lead">
                Coordinate employee records, attendance, leave, and payroll foundations from a single platform with quarterly billing discipline.
                Move faster, stay audit-ready, and keep access aligned with subscription status.
            </p>

            <div class="mk-hero-actions">
                <a href="/pricing" class="mk-btn mk-btn-primary">Explore Quarterly Plans</a>
                <a href="/login" class="mk-btn mk-btn-muted">Sign In to Continue</a>
            </div>

            <dl class="mk-hero-metrics" aria-label="Platform metrics">
                <div>
                    <dt>Billing model</dt>
                    <dd>Quarterly by design</dd>
                </div>
                <div>
                    <dt>Access flow</dt>
                    <dd>Billing-first workspace entry</dd>
                </div>
                <div>
                    <dt>Plan catalog</dt>
                    <dd><?= e((string) max(1, count($planRows))) ?> subscription tiers</dd>
                </div>
            </dl>
        </div>

        <aside class="mk-hero-aside" aria-label="Operational pulse" data-reveal style="--mk-delay: .12s;">
            <p class="mk-aside-label">Operational pulse</p>
            <ul class="mk-pulse-list">
                <li>
                    <span>People core</span>
                    <strong>Central employee records and role-aware access.</strong>
                </li>
                <li>
                    <span>Daily rhythm</span>
                    <strong>Attendance and leave tracking in one workflow.</strong>
                </li>
                <li>
                    <span>Billing control</span>
                    <strong>Test checkout modes for safe subscription validation.</strong>
                </li>
            </ul>
        </aside>
    </section>

    <section class="mk-proof-strip" data-reveal style="--mk-delay: .18s;" aria-label="Trust strip">
        <p class="mk-proof-label">Trusted operations principles</p>
        <div class="mk-proof-items">
            <span>Role-based permissions</span>
            <span>CSRF and session protections</span>
            <span>Lifecycle-safe subscription states</span>
            <span>Mobile-friendly execution</span>
        </div>
    </section>

    <section class="mk-feature-story" aria-labelledby="mk-feature-title" data-reveal style="--mk-delay: .24s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Feature Highlights</p>
            <h2 id="mk-feature-title" class="font-display">An HR workflow with continuity from record to payroll readiness</h2>
            <p>The platform is structured as an operational timeline, so every module advances the next one without rework.</p>
        </div>

        <div class="mk-feature-flow">
            <article class="mk-feature-item" data-reveal style="--mk-delay: .28s;">
                <span class="mk-feature-index">01</span>
                <div>
                    <h3>Employee Structure First</h3>
                    <p>Maintain reliable employee data, hierarchy, and status so approvals and payroll logic always start from accurate records.</p>
                </div>
            </article>
            <article class="mk-feature-item" data-reveal style="--mk-delay: .32s;">
                <span class="mk-feature-index">02</span>
                <div>
                    <h3>Attendance and Leave Continuity</h3>
                    <p>Capture attendance and leave in a shared operational context to reduce manual reconciliation and reporting friction.</p>
                </div>
            </article>
            <article class="mk-feature-item" data-reveal style="--mk-delay: .36s;">
                <span class="mk-feature-index">03</span>
                <div>
                    <h3>Subscription-Aware Access</h3>
                    <p>Protect core modules with subscription state checks so billing and platform access remain synchronized automatically.</p>
                </div>
            </article>
        </div>
    </section>

    <section class="mk-plan-section" aria-labelledby="mk-plan-title" data-reveal style="--mk-delay: .40s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Plan Preview</p>
            <h2 id="mk-plan-title" class="font-display">Choose a quarterly tier that matches your current operating stage</h2>
            <p>Enterprise remains contact-sales only in this test release.</p>
        </div>

        <?php if (!$hasPlans): ?>
            <div class="alert alert-danger">No active plans are available yet. Reload after seeding plan data.</div>
        <?php else: ?>
            <div class="mk-plan-cards">
                <?php foreach ($planRows as $plan): ?>
                    <?php
                    $planCode = strtoupper((string) ($plan['plan_code'] ?? ''));
                    $features = json_decode((string) ($plan['feature_flags'] ?? '[]'), true);
                    $featureItems = is_array($features) ? $features : [];
                    $isContactOnly = (int) ($plan['is_contact_only'] ?? 0) === 1;
                    $employeeLimit = $plan['employee_limit'] ?? null;

                    $tierClass = 'is-starter';
                    $tierTag = 'Starter tier';

                    if (str_contains($planCode, 'GROWTH')) {
                        $tierClass = 'is-recommended';
                        $tierTag = 'Recommended';
                    } elseif (str_contains($planCode, 'ENTERPRISE')) {
                        $tierClass = 'is-enterprise';
                        $tierTag = 'Contact sales';
                    }
                    ?>
                    <article class="mk-plan-card <?= e($tierClass) ?>" data-reveal style="--mk-delay: .44s;">
                        <header class="mk-plan-head">
                            <span class="mk-plan-tag"><?= e($tierTag) ?></span>
                            <p class="mk-plan-name font-display"><?= e((string) ($plan['plan_name'] ?? 'Plan')) ?></p>
                            <p class="mk-plan-price">
                                <?= $isContactOnly ? 'Contact Sales' : 'PHP ' . e(number_format((float) ($plan['price_amount'] ?? 0), 2)) ?>
                                <span><?= $isContactOnly ? '' : '/ quarter' ?></span>
                            </p>
                        </header>

                        <p class="mk-plan-desc"><?= e((string) ($plan['description'] ?? '')) ?></p>

                        <ul class="mk-plan-list">
                            <?php foreach (array_slice($featureItems, 0, 5) as $feature): ?>
                                <li><?= e(ucwords(str_replace('_', ' ', (string) $feature))) ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="mk-plan-bottom">
                            <?php if (!$isContactOnly && $employeeLimit !== null): ?>
                                <p class="mk-plan-cap">Up to <?= e((string) (int) $employeeLimit) ?> employees in this tier</p>
                            <?php else: ?>
                                <p class="mk-plan-cap">Custom capacity, onboarding, and support path</p>
                            <?php endif; ?>

                            <form method="post" action="/subscribe" class="mk-plan-actions">
                                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                                <input type="hidden" name="plan_id" value="<?= (int) ($plan['id'] ?? 0) ?>">
                                <input type="hidden" name="billing_cycle" value="quarterly">
                                <button class="mk-btn <?= $isContactOnly ? 'mk-btn-muted' : 'mk-btn-primary' ?>" type="submit">
                                    <?= $isContactOnly ? 'Select Enterprise' : 'Select ' . e((string) ($plan['plan_name'] ?? 'Plan')) ?>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p class="mk-footnote">Need deeper details? <a href="/pricing">Open complete pricing, comparison, and FAQ.</a></p>
    </section>

    <?php if ($hasPlans): ?>
        <section class="mk-compare-section" aria-labelledby="mk-compare-title" data-reveal style="--mk-delay: .48s;">
            <div class="mk-section-head">
                <p class="mk-kicker">Detailed Comparison</p>
                <h2 id="mk-compare-title" class="font-display">Side-by-side capability coverage</h2>
            </div>

            <div class="mk-compare-table-wrap">
                <table class="mk-compare-table">
                    <thead>
                        <tr>
                            <th>Capability</th>
                            <?php foreach ($planRows as $plan): ?>
                                <th><?= e((string) ($plan['plan_name'] ?? 'Plan')) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comparisonRows as $featureKey => $label): ?>
                            <tr>
                                <th><?= e($label) ?></th>
                                <?php foreach ($planRows as $plan): ?>
                                    <?php
                                    $planId = (int) ($plan['id'] ?? 0);
                                    $enabled = in_array($featureKey, $planFeatures[$planId] ?? [], true);
                                    ?>
                                    <td class="<?= $enabled ? 'is-on' : 'is-off' ?>"><?= $enabled ? 'Included' : 'Not included' ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <?php endif; ?>

    <section class="mk-bottom-grid" data-reveal style="--mk-delay: .52s;">
        <div class="mk-faq" aria-labelledby="mk-faq-title">
            <h2 id="mk-faq-title" class="font-display">FAQ</h2>

            <article>
                <h3>Can we switch to monthly billing now?</h3>
                <p>Not yet. This release is intentionally quarterly-first to stabilize subscription and access workflows.</p>
            </article>
            <article>
                <h3>When does module access unlock?</h3>
                <p>Protected modules unlock when subscription status is active or trialing.</p>
            </article>
            <article>
                <h3>How is Enterprise handled?</h3>
                <p>Enterprise remains contact-sales only for this testing phase.</p>
            </article>
        </div>

        <aside class="mk-final-cta" aria-label="Final call to action">
            <p class="mk-kicker">Start now</p>
            <h2 class="font-display">Select a plan, sign in, and run your billing-ready HR workspace.</h2>
            <p>Begin with quarterly checkout simulation today and move to production payment rails when your team is ready.</p>

            <div class="mk-hero-actions">
                <a class="mk-btn mk-btn-primary" href="/pricing">Choose a Plan</a>
                <a class="mk-btn mk-btn-muted" href="/login">Go to Sign In</a>
            </div>
        </aside>
    </section>
</div>
