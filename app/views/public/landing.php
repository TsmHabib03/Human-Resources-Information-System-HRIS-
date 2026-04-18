<?php
$planRows = is_array($plans ?? null) ? $plans : [];
$hasPlans = $planRows !== [];
$isTestingMode = is_subscription_testing_mode();
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
            <a href="#plans">Plans</a>
            <a href="/pricing">Pricing</a>
            <a href="/login">Sign in</a>
            <a href="/pricing" class="mk-nav-cta">Start free</a>
        </nav>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="mk-hero-panel" aria-labelledby="mk-hero-title" data-reveal style="--mk-delay: .05s;">
        <div class="mk-hero-main">
            <p class="mk-kicker">Daily Command Center</p>
            <h1 id="mk-hero-title" class="font-display">Run your HR operations from one dashboard-ready workspace.</h1>
            <p class="mk-hero-summary">
                <?= $isTestingMode
                    ? 'Select a plan, unlock modules by feature entitlement, and validate attendance, leave, and payroll flow in testing mode.'
                    : 'Move from onboarding to payroll with one consistent command layer where permissions, approvals, and billing stay aligned.' ?>
            </p>

            <div class="mk-hero-actions">
                <a href="/pricing" class="mk-btn mk-btn-primary">Start your plan</a>
                <a href="/login" class="mk-btn mk-btn-muted">Open workspace</a>
            </div>

            <div class="mk-hero-tags" aria-label="Highlights">
                <span class="mk-hero-tag is-blue">Attendance Live</span>
                <span class="mk-hero-tag is-teal">Leave Workflow</span>
                <span class="mk-hero-tag is-coral">Payroll Queue</span>
            </div>
        </div>

        <aside class="mk-hero-side" aria-label="Platform summary">
            <p class="mk-side-label">Active plan tiers</p>
            <p class="mk-side-value"><?= e((string) max(1, count($planRows))) ?></p>
            <p class="mk-side-meta">Choose a tier and continue to sign-in to activate your access path.</p>

            <dl class="mk-hero-stats">
                <div class="mk-hero-stat">
                    <dt>Mode</dt>
                    <dd><?= $isTestingMode ? 'Testing' : 'Production' ?></dd>
                </div>
                <div class="mk-hero-stat">
                    <dt>Module lock</dt>
                    <dd><?= $isTestingMode ? 'Feature + role' : 'Subscription + role' ?></dd>
                </div>
                <div class="mk-hero-stat">
                    <dt>Billing cycle</dt>
                    <dd>Quarterly</dd>
                </div>
            </dl>
        </aside>
    </section>

    <section class="mk-plan-section" id="plans" aria-labelledby="mk-plan-title" data-reveal style="--mk-delay: .1s;">
        <div class="mk-section-head">
            <p class="mk-kicker">Subscription Cards</p>
            <h2 id="mk-plan-title" class="font-display">Choose the plan that matches your rollout stage.</h2>
            <p>
                <?= $isTestingMode
                    ? 'In testing mode, module access is unlocked instantly by selected feature coverage.'
                    : 'In production mode, valid subscription state and plan feature coverage both control access.' ?>
            </p>
        </div>

        <?php if (!$hasPlans): ?>
            <div class="alert alert-danger">No active plans are available yet. Reload after seeding plan data.</div>
        <?php else: ?>
            <div class="mk-plan-cards">
                <?php foreach ($planRows as $index => $plan): ?>
                    <?php
                    $planCode = strtoupper((string) ($plan['plan_code'] ?? ''));
                    $planDisplayName = display_plan_name_for_access((string) ($plan['plan_name'] ?? 'Plan'));
                    $features = json_decode((string) ($plan['feature_flags'] ?? '[]'), true);
                    $featureItems = is_array($features) ? $features : [];
                    $featureCount = count($featureItems);
                    $isContactOnly = (int) ($plan['is_contact_only'] ?? 0) === 1;
                    $employeeLimit = $plan['employee_limit'] ?? null;
                    $planHook = 'Reliable entry tier for launching attendance and core HR workflows.';
                    $confidence = 86;
                    $cardDelay = number_format(0.14 + ($index * 0.05), 2, '.', '');

                    $tierClass = 'is-starter';
                    $tierTag = 'Starter';

                    if (str_contains($planCode, 'GROWTH')) {
                        $tierClass = 'is-recommended';
                        $tierTag = 'Recommended';
                        $planHook = 'Most selected by teams running full daily operations.';
                        $confidence = 94;
                    } elseif (str_contains($planCode, 'ENTERPRISE')) {
                        $tierClass = 'is-enterprise';
                        $tierTag = 'Contact sales';
                        $planHook = 'Built for organizations with advanced governance and support needs.';
                        $confidence = 98;
                    }

                    $modalPrice = $isContactOnly
                        ? 'Contact Sales'
                        : 'PHP ' . number_format((float) ($plan['price_amount'] ?? 0), 2) . ' / quarter';
                    ?>
                    <article class="mk-plan-card <?= e($tierClass) ?>" data-reveal style="--mk-delay: <?= e($cardDelay) ?>s;">
                        <header class="mk-plan-head">
                            <span class="mk-plan-tag"><?= e($tierTag) ?></span>
                            <p class="mk-plan-name font-display"><?= e($planDisplayName) ?></p>
                            <p class="mk-plan-price">
                                <?= $isContactOnly ? 'Contact Sales' : 'PHP ' . e(number_format((float) ($plan['price_amount'] ?? 0), 2)) ?>
                                <span><?= $isContactOnly ? '' : '/ quarter' ?></span>
                            </p>
                            <div class="mk-plan-meta">
                                <span><strong><?= e((string) max(1, $featureCount)) ?></strong> modules</span>
                                <span><?= $isContactOnly ? 'Guided onboarding' : 'Self-serve rollout' ?></span>
                            </div>
                        </header>

                        <p class="mk-plan-desc"><?= e((string) ($plan['description'] ?? '')) ?></p>

                        <div class="mk-plan-psych">
                            <p class="mk-plan-social <?= e($tierClass) ?>"><?= e($planHook) ?></p>
                            <?php if (!$isContactOnly): ?>
                                <p class="mk-plan-anchor">Equivalent to <?= e('PHP ' . number_format(((float) ($plan['price_amount'] ?? 0)) / 3, 2)) ?>/month billed quarterly.</p>
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
                                    <?= $isContactOnly ? 'Talk to sales' : 'Start with ' . e($planDisplayName) ?>
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <p class="mk-footnote">Need detailed comparison? <a href="/pricing">Open full pricing and module matrix.</a></p>
    </section>

    <section class="mk-final-cta-panel" data-reveal style="--mk-delay: .15s;">
        <p class="mk-kicker">Launch Fast</p>
        <h2 class="font-display">Move from disconnected tracking to one execution-ready HR workspace.</h2>
        <p>
            <?= $isTestingMode
                ? 'Pick your plan, sign in, and validate feature-lock behavior before production cutover.'
                : 'Pick your plan, sign in, and continue through production-ready subscription controls.' ?>
        </p>

        <div class="mk-hero-actions">
            <a class="mk-btn mk-btn-primary" href="/pricing">Choose a plan</a>
            <a class="mk-btn mk-btn-muted" href="/login">Go to sign in</a>
        </div>
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
                <li>Feature access remains aligned with selected subscription coverage.</li>
                <li>Role-based permissions continue to apply across every module.</li>
                <li>You can switch plans later from billing controls.</li>
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
