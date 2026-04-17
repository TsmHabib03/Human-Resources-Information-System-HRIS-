<?php
$planRows = is_array($plans ?? null) ? $plans : [];
$defaultPlanId = 0;
$defaultPlanName = '';

foreach ($planRows as $plan) {
    if ((int) ($plan['is_contact_only'] ?? 0) === 0) {
        $defaultPlanId = (int) ($plan['id'] ?? 0);
        $defaultPlanName = (string) ($plan['plan_name'] ?? 'Plan');
        break;
    }
}

if ($defaultPlanId === 0 && $planRows !== []) {
    $defaultPlanId = (int) ($planRows[0]['id'] ?? 0);
    $defaultPlanName = (string) ($planRows[0]['plan_name'] ?? 'Plan');
}

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

<div class="mk-shell mk-shell-pricing">
    <header class="mk-topbar" data-reveal style="--mk-delay: 0s;">
        <a class="mk-brand" href="/">
            <span class="mk-brand-dot" aria-hidden="true"></span>
            <span>
                <strong class="font-display">HRIS Cloud</strong>
                <small>Quarterly Subscription</small>
            </span>
        </a>

        <nav class="mk-nav" aria-label="Pricing navigation">
            <a href="/">Landing</a>
            <a href="/login" class="mk-login-link">Sign in</a>
        </nav>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="mk-pricing-hero" aria-labelledby="mk-pricing-title" data-reveal style="--mk-delay: .06s;">
        <p class="mk-kicker">Pricing</p>
        <h1 id="mk-pricing-title" class="font-display">Choose the quarterly tier that fits your HR operating stage</h1>
        <p>Select a plan now, sign in, and continue checkout simulation from billing controls.</p>
    </section>

    <?php if (!$hasPlans): ?>
        <section class="mk-pricing-form" data-reveal style="--mk-delay: .12s;">
            <div class="alert alert-danger">No active plans were found. Run roles and demo seed files, then refresh this page.</div>
            <div class="mk-pricing-actions">
                <a class="mk-btn mk-btn-muted" href="/">Return to landing</a>
            </div>
        </section>
    <?php else: ?>
        <form class="mk-pricing-form" method="post" action="/subscribe" data-plan-picker data-reveal style="--mk-delay: .12s;">
            <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
            <input type="hidden" name="billing_cycle" value="quarterly">

            <div class="mk-selection-summary" data-selection-summary>
                <p class="mk-kicker">Selection Preview</p>
                <p class="mk-selection-plan" data-selection-plan><?= e($defaultPlanName !== '' ? $defaultPlanName : 'No plan selected') ?></p>
                <p class="mk-selection-note">Quarterly billing is fixed in this release. Enterprise remains contact-sales only.</p>
            </div>

            <div class="mk-pricing-layout">
                <div class="mk-plan-cards mk-plan-cards-pricing" aria-label="Plan options">
                    <?php foreach ($planRows as $index => $plan): ?>
                        <?php
                        $planId = (int) ($plan['id'] ?? 0);
                        $features = json_decode((string) ($plan['feature_flags'] ?? '[]'), true);
                        $featureItems = is_array($features) ? $features : [];
                        $isContactOnly = (int) ($plan['is_contact_only'] ?? 0) === 1;
                        $isChecked = $defaultPlanId === $planId;
                        $planCode = strtoupper((string) ($plan['plan_code'] ?? ''));

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
                        <label
                            class="mk-plan-card <?= e($tierClass) ?> <?= $isChecked ? 'is-selected' : '' ?>"
                            data-plan-card
                            data-plan-name="<?= e((string) ($plan['plan_name'] ?? 'Plan')) ?>"
                        >
                            <input
                                type="radio"
                                name="plan_id"
                                value="<?= $planId ?>"
                                <?= $isChecked ? 'checked' : '' ?>
                                <?= $index === 0 ? 'required' : '' ?>
                                class="mk-plan-input"
                            >

                            <span class="mk-plan-tag"><?= e($tierTag) ?></span>

                            <div class="mk-plan-head">
                                <p class="mk-plan-name font-display"><?= e((string) ($plan['plan_name'] ?? 'Plan')) ?></p>
                                <p class="mk-plan-price">
                                    <?= $isContactOnly ? 'Contact Sales' : 'PHP ' . e(number_format((float) ($plan['price_amount'] ?? 0), 2)) ?>
                                    <span><?= $isContactOnly ? '' : '/ quarter' ?></span>
                                </p>
                            </div>

                            <p class="mk-plan-desc"><?= e((string) ($plan['description'] ?? '')) ?></p>

                            <ul class="mk-plan-list">
                                <?php foreach (array_slice($featureItems, 0, 6) as $feature): ?>
                                    <li><?= e(ucwords(str_replace('_', ' ', (string) $feature))) ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <?php if ($isContactOnly): ?>
                                <span class="mk-pill">Contact-sales flow</span>
                            <?php else: ?>
                                <span class="mk-pill">Selectable plan</span>
                            <?php endif; ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <aside class="mk-pricing-side" aria-label="Selection details">
                    <h2 class="font-display">How onboarding works</h2>
                    <ol>
                        <li>Select your quarterly tier from the plan deck.</li>
                        <li>Sign in to your account and open billing controls.</li>
                        <li>Simulate checkout to validate success, pending, or failed states.</li>
                    </ol>

                    <div class="mk-side-note">
                        <p class="mk-kicker">Compliance confidence</p>
                        <p>Role checks and subscription gates are enforced before protected module access.</p>
                    </div>

                    <div class="mk-side-note">
                        <p class="mk-kicker">Enterprise route</p>
                        <p>Enterprise keeps a contact-sales path for assisted onboarding and custom agreements.</p>
                    </div>
                </aside>
            </div>

            <p class="mk-live-region" aria-live="polite"></p>

            <div class="mk-pricing-actions">
                <button
                    class="mk-btn mk-btn-primary"
                    type="submit"
                    data-submit-label="Select Plan and Continue"
                    data-loading-label="Processing selection..."
                >
                    Select Plan and Continue
                </button>
                <a class="mk-btn mk-btn-muted" href="/login">Already have an account</a>
            </div>
        </form>
    <?php endif; ?>

    <?php if ($hasPlans): ?>
        <section class="mk-compare-section" aria-labelledby="mk-compare-title" data-reveal style="--mk-delay: .18s;">
            <div class="mk-section-head">
                <p class="mk-kicker">Detailed Comparison</p>
                <h2 id="mk-compare-title" class="font-display">Review coverage before you commit</h2>
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

    <section class="mk-faq" aria-labelledby="mk-faq-title" data-reveal style="--mk-delay: .24s;">
        <h2 id="mk-faq-title" class="font-display">FAQ</h2>
        <article>
            <h3>Can we enable monthly billing now?</h3>
            <p>No. Monthly billing is intentionally disabled for this release.</p>
        </article>
        <article>
            <h3>Is payment processed in this environment?</h3>
            <p>No. Checkout outcomes are simulated to validate subscription behavior safely.</p>
        </article>
        <article>
            <h3>Can Enterprise self-checkout immediately?</h3>
            <p>Enterprise stays on a contact-sales path during this testing phase.</p>
        </article>
    </section>
</div>
