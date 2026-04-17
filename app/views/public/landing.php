<?php
$planRows = is_array($plans ?? null) ? $plans : [];
$hasPlans = $planRows !== [];
$isTestingMode = is_subscription_testing_mode();

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
                <small><?= $isTestingMode ? 'Testing Access Mode' : 'Production Billing Mode' ?></small>
            </span>
        </a>

        <nav class="mk-nav" aria-label="Main navigation">
            <a href="/pricing">Pricing</a>
            <a href="/login" class="mk-login-link">Sign in</a>
        </nav>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="mk-lp-hero" aria-labelledby="mk-hero-title">
        <div class="mk-lp-copy" data-reveal style="--mk-delay: .05s;">
            <p class="mk-kicker">HR SaaS Landing</p>
            <h1 id="mk-hero-title" class="font-display">Operate people, attendance, and payroll from one clean command layer.</h1>
            <p class="mk-lp-summary">
                <?= $isTestingMode
                    ? 'Choose a plan to control module access instantly. Payment simulation remains optional while you validate your HR workflow end-to-end.'
                    : 'Run your workforce operations through one reliable platform where access, approvals, and billing stay aligned by design.' ?>
            </p>

            <div class="mk-lp-hero-actions">
                <a href="/pricing" class="mk-btn mk-btn-primary">Explore Pricing and Access</a>
                <a href="/login" class="mk-btn mk-btn-muted">Sign In to Workspace</a>
            </div>

            <div class="mk-lp-chip-row" aria-label="Highlights">
                <span class="mk-chip is-accent">Fully Editable</span>
                <span class="mk-chip">Style Guides</span>
                <span class="mk-chip">Auto Layout</span>
                <span class="mk-chip">HRIS Frontend</span>
            </div>

            <dl class="mk-lp-kpis" aria-label="Platform metrics">
                <div>
                    <dt>Plan model</dt>
                    <dd><?= $isTestingMode ? 'Feature lock first' : 'Billing first' ?></dd>
                </div>
                <div>
                    <dt>Tier count</dt>
                    <dd><?= e((string) max(1, count($planRows))) ?> active plans</dd>
                </div>
                <div>
                    <dt>Readiness</dt>
                    <dd><?= $isTestingMode ? 'Testing rollout enabled' : 'Production controls enabled' ?></dd>
                </div>
            </dl>
        </div>

        <aside class="mk-lp-visual" aria-label="Product preview" data-reveal style="--mk-delay: .12s;">
            <article class="mk-window mk-window-far" aria-hidden="true">
                <header class="mk-window-head">
                    <span class="mk-dot"></span><span class="mk-dot"></span><span class="mk-dot"></span>
                </header>
            </article>

            <article class="mk-window mk-window-main" aria-hidden="true">
                <header class="mk-window-head">
                    <div class="mk-window-dots">
                        <span class="mk-dot"></span><span class="mk-dot"></span><span class="mk-dot"></span>
                    </div>
                    <p class="mk-window-title">HRIS Cloud Dashboard</p>
                    <span class="mk-window-pill">Live</span>
                </header>

                <div class="mk-window-metrics">
                    <div class="mk-window-metric">
                        <p>Total employees</p>
                        <strong>164</strong>
                    </div>
                    <div class="mk-window-metric">
                        <p>Leave approvals</p>
                        <strong>12</strong>
                    </div>
                    <div class="mk-window-metric">
                        <p>Attendance trend</p>
                        <strong>+8%</strong>
                    </div>
                </div>

                <div class="mk-window-grid">
                    <article class="mk-window-card">
                        <h3>Time Off</h3>
                        <p>16 pending requests routed for manager review.</p>
                    </article>
                    <article class="mk-window-card">
                        <h3>Payroll Readiness</h3>
                        <p>Draft cycle prepared for 3 departments.</p>
                    </article>
                    <article class="mk-window-card">
                        <h3>Compliance</h3>
                        <p>CSRF and access policies healthy across modules.</p>
                    </article>
                    <article class="mk-window-card mk-window-curve">
                        <h3>Adoption</h3>
                        <p>82% daily usage in the current workspace cohort.</p>
                    </article>
                </div>
            </article>
        </aside>
    </section>

    <section class="mk-lp-logos" data-reveal style="--mk-delay: .18s;" aria-label="Trusted companies">
        <p>Trusted by teams modernizing HR operations</p>
        <div class="mk-logo-list" role="list">
            <span role="listitem">Atlas Retail</span>
            <span role="listitem">Northline Foods</span>
            <span role="listitem">Bluenet Services</span>
            <span role="listitem">Metrobuild Corp</span>
            <span role="listitem">Silva Logistics</span>
        </div>
    </section>

    <section class="mk-lp-pillars" aria-labelledby="mk-pillar-title" data-reveal style="--mk-delay: .24s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Core Value</p>
            <h2 id="mk-pillar-title" class="font-display">Built for HR teams that need speed, traceability, and clean approvals.</h2>
            <p>Every module shares one experience language so your team can move faster without losing control.</p>
        </div>

        <div class="mk-lp-pillar-grid">
            <article class="mk-lp-pillar" data-reveal style="--mk-delay: .28s;">
                <p class="mk-pill-index">01</p>
                <h3>Employee source of truth</h3>
                <p>Manage profiles, reporting lines, and role ownership from a single reliable model.</p>
            </article>
            <article class="mk-lp-pillar" data-reveal style="--mk-delay: .32s;">
                <p class="mk-pill-index">02</p>
                <h3>Workflow continuity</h3>
                <p>Attendance and leave follow one operational path so reviews and history stay consistent.</p>
            </article>
            <article class="mk-lp-pillar" data-reveal style="--mk-delay: .36s;">
                <p class="mk-pill-index">03</p>
                <h3>Access by entitlement</h3>
                <p>Plan features decide module coverage while role permissions preserve governance boundaries.</p>
            </article>
        </div>
    </section>

    <section class="mk-plan-section mk-lp-plan-section" aria-labelledby="mk-plan-title" data-reveal style="--mk-delay: .4s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Plan Preview</p>
            <h2 id="mk-plan-title" class="font-display">Pick a plan and shape your module access path.</h2>
            <p>
                <?= $isTestingMode
                    ? 'In testing mode, selected plan features unlock modules immediately. Checkout simulation remains optional.'
                    : 'In production mode, subscription status and plan coverage both determine workspace availability.' ?>
            </p>
        </div>

        <?php if (!$hasPlans): ?>
            <div class="alert alert-danger">No active plans are available yet. Reload after seeding plan data.</div>
        <?php else: ?>
            <div class="mk-plan-cards mk-lp-plan-cards">
                <?php foreach ($planRows as $plan): ?>
                    <?php
                    $planCode = strtoupper((string) ($plan['plan_code'] ?? ''));
                    $planDisplayName = display_plan_name_for_access((string) ($plan['plan_name'] ?? 'Plan'));
                    $features = json_decode((string) ($plan['feature_flags'] ?? '[]'), true);
                    $featureItems = is_array($features) ? $features : [];
                    $isContactOnly = (int) ($plan['is_contact_only'] ?? 0) === 1;
                    $employeeLimit = $plan['employee_limit'] ?? null;
                    $planHook = 'Great for pilot teams launching core HR workflows quickly.';
                    $confidence = 86;

                    $tierClass = 'is-starter';
                    $tierTag = 'Starter';

                    if (str_contains($planCode, 'GROWTH')) {
                        $tierClass = 'is-recommended';
                        $tierTag = 'Recommended';
                        $planHook = 'Most selected by teams rolling out full HR operations.';
                        $confidence = 94;
                    } elseif (str_contains($planCode, 'ENTERPRISE')) {
                        $tierClass = 'is-enterprise';
                        $tierTag = 'Contact sales';
                        $planHook = 'Built for mature organizations prioritizing governance and support.';
                        $confidence = 98;
                    }

                    $modalPrice = $isContactOnly
                        ? 'Contact Sales'
                        : 'PHP ' . number_format((float) ($plan['price_amount'] ?? 0), 2) . ' / quarter';
                    ?>
                    <article class="mk-plan-card mk-lp-plan-card <?= e($tierClass) ?>" data-reveal style="--mk-delay: .44s;">
                        <header class="mk-plan-head">
                            <span class="mk-plan-tag"><?= e($tierTag) ?></span>
                            <p class="mk-plan-name font-display"><?= e($planDisplayName) ?></p>
                            <p class="mk-plan-price">
                                <?= $isContactOnly ? 'Contact Sales' : 'PHP ' . e(number_format((float) ($plan['price_amount'] ?? 0), 2)) ?>
                                <span><?= $isContactOnly ? '' : '/ quarter' ?></span>
                            </p>
                        </header>

                        <p class="mk-plan-desc"><?= e((string) ($plan['description'] ?? '')) ?></p>

                        <div class="mk-plan-psych">
                            <p class="mk-plan-social <?= e($tierClass) ?>"><?= e($planHook) ?></p>
                            <?php if (!$isContactOnly): ?>
                                <div class="mk-plan-confidence" aria-label="Plan confidence score">
                                    <div class="mk-plan-confidence-head">
                                        <span>Adoption confidence</span>
                                        <strong><?= e((string) $confidence) ?>%</strong>
                                    </div>
                                    <span class="mk-plan-meter" aria-hidden="true"><span style="width: <?= e((string) $confidence) ?>%"></span></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <ul class="mk-plan-list">
                            <?php foreach (array_slice($featureItems, 0, 5) as $feature): ?>
                                <li><?= e(ucwords(str_replace('_', ' ', (string) $feature))) ?></li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="mk-plan-bottom">
                            <?php if (!$isContactOnly && $employeeLimit !== null): ?>
                                <p class="mk-plan-cap">Up to <?= e((string) (int) $employeeLimit) ?> employees included</p>
                            <?php else: ?>
                                <p class="mk-plan-cap">Custom capacity, assisted onboarding, and dedicated support</p>
                            <?php endif; ?>

                            <form
                                method="post"
                                action="/subscribe"
                                class="mk-plan-actions"
                                data-plan-modal-form
                                data-plan-name="<?= e($planDisplayName) ?>"
                                data-plan-price="<?= e($modalPrice) ?>"
                                data-plan-hook="<?= e($planHook) ?>"
                            >
                                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                                <input type="hidden" name="plan_id" value="<?= (int) ($plan['id'] ?? 0) ?>">
                                <input type="hidden" name="billing_cycle" value="quarterly">
                                <button class="mk-btn <?= $isContactOnly ? 'mk-btn-muted' : 'mk-btn-primary' ?>" type="submit">
                                    <?= $isContactOnly ? 'Select Enterprise' : 'Select ' . e($planDisplayName) ?>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p class="mk-footnote">Need complete details? <a href="/pricing">Open full pricing matrix and FAQ.</a></p>
    </section>

    <?php if ($hasPlans): ?>
        <section class="mk-compare-section mk-lp-compare" aria-labelledby="mk-compare-title" data-reveal style="--mk-delay: .48s;">
            <div class="mk-section-head">
                <p class="mk-kicker">Capability Matrix</p>
                <h2 id="mk-compare-title" class="font-display">Compare feature coverage across every plan.</h2>
            </div>

            <div class="mk-compare-table-wrap">
                <table class="mk-compare-table">
                    <thead>
                        <tr>
                            <th>Capability</th>
                            <?php foreach ($planRows as $plan): ?>
                                <th><?= e(display_plan_name_for_access((string) ($plan['plan_name'] ?? 'Plan'))) ?></th>
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
                <h3><?= $isTestingMode ? 'Do we need live payments for access right now?' : 'Can we start with monthly billing?' ?></h3>
                <p>
                    <?= $isTestingMode
                        ? 'No. Testing mode unlocks by selected plan feature flags. Payment outcomes can be simulated optionally.'
                        : 'No. This release keeps quarterly billing for stable rollout and clean governance.' ?>
                </p>
            </article>
            <article>
                <h3>When are modules available?</h3>
                <p>
                    <?= $isTestingMode
                        ? 'When the selected testing plan includes the module feature and your role has the right permission.'
                        : 'When subscription state is valid and your role permission allows access.' ?>
                </p>
            </article>
            <article>
                <h3>How is Enterprise handled?</h3>
                <p>Enterprise remains contact-sales only during this phase for guided onboarding.</p>
            </article>
        </div>

        <aside class="mk-final-cta mk-lp-final" aria-label="Final call to action">
            <p class="mk-kicker">Launch Fast</p>
            <h2 class="font-display">Move from disconnected HR tracking to one execution-ready workspace.</h2>
            <p>
                <?= $isTestingMode
                    ? 'Choose your plan, sign in, and validate feature-lock behavior before production cutover.'
                    : 'Choose your plan, sign in, and run full subscription flow with production controls.' ?>
            </p>

            <div class="mk-lp-hero-actions">
                <a class="mk-btn mk-btn-primary" href="/pricing">Choose a Plan</a>
                <a class="mk-btn mk-btn-muted" href="/login">Go to Sign In</a>
            </div>
        </aside>
    </section>

    <div class="mk-plan-modal-backdrop" id="planDecisionModal" hidden>
        <div class="mk-plan-modal" role="dialog" aria-modal="true" aria-labelledby="mk-plan-modal-title" aria-describedby="mk-plan-modal-copy">
            <button class="mk-plan-modal-close" type="button" data-plan-modal-close aria-label="Close plan modal">&times;</button>
            <p class="mk-kicker">Plan decision</p>
            <h2 id="mk-plan-modal-title" class="font-display">Confirm your plan before continuing</h2>
            <p class="mk-plan-modal-name" data-plan-modal-name>Selected plan</p>
            <p class="mk-plan-modal-price" data-plan-modal-price>Pricing</p>
            <p id="mk-plan-modal-copy" class="mk-plan-modal-copy" data-plan-modal-hook>Plan recommendation</p>

            <ul class="mk-plan-modal-points">
                <li>Visible feature locks guide users to the right upgrade moment.</li>
                <li>Your role permissions remain enforced in every module.</li>
                <li>You can switch plans any time from billing controls.</li>
            </ul>

            <div class="mk-plan-modal-actions">
                <button class="mk-btn mk-btn-primary" type="button" data-plan-modal-confirm>Continue with this plan</button>
                <button class="mk-btn mk-btn-muted" type="button" data-plan-modal-close>Review again</button>
            </div>
        </div>
    </div>

    <div class="mk-loading-overlay" id="planLoadingOverlay" hidden aria-live="polite">
        <div class="mk-loading-card" role="status">
            <span class="mk-loading-spinner" aria-hidden="true"></span>
            <p class="mk-loading-title">Applying your plan selection...</p>
            <p class="mk-loading-copy">Preparing access logic and routing your next step.</p>
        </div>
    </div>
</div>
