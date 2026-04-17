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

<div class="mk-shell mk-shell-landing">
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

    <section class="mk-lp-hero" aria-labelledby="mk-hero-title">
        <div class="mk-lp-copy" data-reveal style="--mk-delay: .06s;">
            <p class="mk-kicker">HR SaaS Platform</p>
            <h1 id="mk-hero-title" class="font-display">Design your workforce system with less admin drag and more execution speed.</h1>
            <p class="mk-lp-summary">
                From employee structure to attendance, leave, and payroll readiness, this platform turns HR operations into one clear execution lane.
                Quarterly subscription gates keep access, billing, and governance in sync.
            </p>

            <div class="mk-lp-hero-actions">
                <a href="/pricing" class="mk-btn mk-btn-primary">Explore Quarterly Plans</a>
                <a href="/login" class="mk-btn mk-btn-muted">Sign In to Continue</a>
            </div>

            <dl class="mk-lp-kpis" aria-label="Platform metrics">
                <div>
                    <dt>Plan structure</dt>
                    <dd>Quarterly-first billing</dd>
                </div>
                <div>
                    <dt>Workspace access</dt>
                    <dd>Billing-verified modules</dd>
                </div>
                <div>
                    <dt>Available tiers</dt>
                    <dd><?= e((string) max(1, count($planRows))) ?> subscription options</dd>
                </div>
            </dl>
        </div>

        <aside class="mk-lp-panel" aria-label="Execution snapshot" data-reveal style="--mk-delay: .12s;">
            <p class="mk-lp-panel-kicker">Execution snapshot</p>

            <article class="mk-lp-panel-card">
                <h2 class="font-display">People foundation</h2>
                <p>Central employee records with role-aware controls and predictable data ownership.</p>
            </article>

            <article class="mk-lp-panel-card">
                <h2 class="font-display">Workflow continuity</h2>
                <p>Attendance and leave move through one shared logic path to reduce reconciliation overhead.</p>
            </article>

            <article class="mk-lp-panel-card">
                <h2 class="font-display">Billing confidence</h2>
                <p>Test checkout outcomes validate access behavior before connecting live payment rails.</p>
            </article>
        </aside>
    </section>

    <section class="mk-lp-strip" data-reveal style="--mk-delay: .18s;" aria-label="Trust strip">
        <p class="mk-proof-label">Built on operational guardrails</p>
        <div class="mk-lp-strip-items">
            <span>Role and permission policy</span>
            <span>CSRF and secure session flow</span>
            <span>Subscription lifecycle controls</span>
            <span>Responsive interface system</span>
        </div>
    </section>

    <section class="mk-lp-orbit" aria-labelledby="mk-feature-title" data-reveal style="--mk-delay: .24s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Feature Highlights</p>
            <h2 id="mk-feature-title" class="font-display">A cleaner operating model for teams that need velocity and traceability</h2>
            <p>Each capability layer is designed to feed the next so your HR process works as one connected system.</p>
        </div>

        <div class="mk-lp-orbit-grid">
            <article class="mk-lp-orbit-card" data-reveal style="--mk-delay: .28s;">
                <p class="mk-lp-orbit-index">01</p>
                <h3>Structure and ownership</h3>
                <p>Keep employee records, reporting lines, and status transitions consistent from onboarding onward.</p>
            </article>
            <article class="mk-lp-orbit-card" data-reveal style="--mk-delay: .32s;">
                <p class="mk-lp-orbit-index">02</p>
                <h3>Operational rhythm</h3>
                <p>Run attendance and leave inside one flow so approvals, visibility, and audit context stay aligned.</p>
            </article>
            <article class="mk-lp-orbit-card" data-reveal style="--mk-delay: .36s;">
                <p class="mk-lp-orbit-index">03</p>
                <h3>Access and billing integrity</h3>
                <p>Subscription state is enforced at module level, so business access follows billing truth automatically.</p>
            </article>
        </div>
    </section>

    <section class="mk-plan-section mk-lp-plan-section" aria-labelledby="mk-plan-title" data-reveal style="--mk-delay: .40s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Plan Preview</p>
            <h2 id="mk-plan-title" class="font-display">Pick the tier that matches your current HR maturity</h2>
            <p>Enterprise remains contact-sales only in this test release and is optimized for assisted rollout.</p>
        </div>

        <?php if (!$hasPlans): ?>
            <div class="alert alert-danger">No active plans are available yet. Reload after seeding plan data.</div>
        <?php else: ?>
            <div class="mk-plan-cards mk-lp-plan-cards">
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
                    <article class="mk-plan-card mk-lp-plan-card <?= e($tierClass) ?>" data-reveal style="--mk-delay: .44s;">
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

        <p class="mk-footnote">Need full details before committing? <a href="/pricing">Open complete pricing, comparison, and FAQ.</a></p>
    </section>

    <?php if ($hasPlans): ?>
        <section class="mk-compare-section mk-lp-compare" aria-labelledby="mk-compare-title" data-reveal style="--mk-delay: .48s;">
            <div class="mk-section-head">
                <p class="mk-kicker">Detailed Comparison</p>
                <h2 id="mk-compare-title" class="font-display">See exact capability coverage across every tier</h2>
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

    <section class="mk-lp-bottom" data-reveal style="--mk-delay: .52s;">
        <div class="mk-faq mk-lp-faq" aria-labelledby="mk-faq-title">
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

        <aside class="mk-final-cta mk-lp-final" aria-label="Final call to action">
            <p class="mk-kicker">Start now</p>
            <h2 class="font-display">Move from static HR tracking to an execution-ready control layer.</h2>
            <p>Choose your tier, sign in, and validate subscription behavior through checkout simulation before production rollout.</p>

            <div class="mk-lp-hero-actions">
                <a class="mk-btn mk-btn-primary" href="/pricing">Choose a Plan</a>
                <a class="mk-btn mk-btn-muted" href="/login">Go to Sign In</a>
            </div>
        </aside>
    </section>
</div>
