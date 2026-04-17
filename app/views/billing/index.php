<?php
$planRows = is_array($plans ?? null) ? $plans : [];
$transactionRows = is_array($transactions ?? null) ? $transactions : [];
$historyRows = is_array($history ?? null) ? $history : [];
$currentSubscription = is_array($current ?? null) ? $current : null;
$hasPlans = $planRows !== [];
$status = is_array($statusSummary ?? null) ? $statusSummary : [
    'label' => 'Unavailable',
    'is_valid' => false,
    'tone' => 'danger',
    'message' => 'Subscription details are not available.',
];

$statusTone = (string) ($status['tone'] ?? 'danger');
$selectedId = (int) ($selectedPlanId ?? 0);
$selectedCycleValue = (string) ($selectedCycle ?? 'quarterly');
$canManage = (bool) ($canManageBilling ?? false);
$isTestingMode = (bool) ($isTestingMode ?? is_subscription_testing_mode());

if ($isTestingMode && !(bool) ($status['is_valid'] ?? false)) {
    $status = [
        'label' => 'Testing Access Mode',
        'is_valid' => true,
        'tone' => 'warning',
        'message' => 'Payment enforcement is disabled in testing mode. Module access follows role permissions and selected plan feature locks.',
    ];
    $statusTone = 'warning';
}
?>

<section class="bill-page">
    <header class="bill-hero">
        <div>
            <p class="bill-kicker">Billing</p>
            <h2 class="bill-title font-display"><?= $isTestingMode ? 'Access and billing control center' : 'Subscription control center' ?></h2>
            <p class="bill-subtitle">
                <?= $isTestingMode
                    ? 'Select a plan to control feature locks. Checkout simulation is available but not required for testing access.'
                    : 'Select your quarterly plan, run checkout simulation, and keep module access in sync with subscription state.' ?>
            </p>
        </div>
        <div class="bill-hero-actions">
            <?php if ($isTestingMode || (bool) ($status['is_valid'] ?? false)): ?>
                <a class="bill-btn bill-btn-primary" href="<?= e((string) ($continuePath ?? '/dashboard')) ?>">Continue to workspace</a>
            <?php endif; ?>
            <a class="bill-btn bill-btn-muted" href="/pricing">View public pricing</a>
        </div>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="bill-grid">
        <article class="bill-card bill-status bill-status-<?= e($statusTone) ?>">
            <p class="bill-status-label"><?= $isTestingMode ? 'Current Access Mode' : 'Current Subscription Status' ?></p>
            <h3><?= e((string) ($status['label'] ?? 'Unavailable')) ?></h3>
            <p><?= e((string) ($status['message'] ?? '')) ?></p>

            <?php if ($currentSubscription !== null): ?>
                <dl class="bill-status-meta">
                    <div>
                        <dt>Plan</dt>
                        <dd><?= e((string) ($currentSubscription['plan_name'] ?? '-')) ?></dd>
                    </div>
                    <div>
                        <dt>Cycle</dt>
                        <dd><?= e((string) ($currentSubscription['billing_cycle'] ?? '-')) ?></dd>
                    </div>
                    <div>
                        <dt>Ends at</dt>
                        <dd><?= e((string) ($currentSubscription['ends_at'] ?? '-')) ?></dd>
                    </div>
                    <div>
                        <dt>Trial ends</dt>
                        <dd><?= e((string) ($currentSubscription['trial_ends_at'] ?? '-')) ?></dd>
                    </div>
                </dl>
            <?php endif; ?>
        </article>

        <article class="bill-card">
            <div class="bill-head">
                <h3><?= $isTestingMode ? 'Select a testing plan and optionally run checkout simulation' : 'Select plan and run test checkout' ?></h3>
                <p>
                    <?= $isTestingMode
                        ? 'Your selected plan controls feature-locked modules immediately. Billing simulation is optional in this mode.'
                        : 'Quarterly billing is fixed for this release.' ?>
                </p>
            </div>

            <?php if (!$hasPlans): ?>
                <div class="alert alert-danger">No active plans are available. Seed plans in the current database and refresh this page.</div>
            <?php else: ?>
                <form method="post" action="/billing/checkout" data-plan-picker>
                    <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

                    <div class="bill-plan-grid">
                        <?php foreach ($planRows as $index => $plan): ?>
                            <?php
                            $planId = (int) ($plan['id'] ?? 0);
                            $planDisplayName = display_plan_name_for_access((string) ($plan['plan_name'] ?? 'Plan'));
                            $isChecked = $selectedId === $planId || ($selectedId === 0 && (int) ($plan['is_contact_only'] ?? 0) === 0);
                            $features = json_decode((string) ($plan['feature_flags'] ?? '[]'), true);
                            $featureItems = is_array($features) ? $features : [];
                            $isContactOnly = (int) ($plan['is_contact_only'] ?? 0) === 1;
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
                                class="bill-plan-card <?= e($tierClass) ?> <?= $isChecked ? 'is-selected' : '' ?>"
                                data-plan-card
                                data-plan-name="<?= e($planDisplayName) ?>"
                            >
                                <input
                                    class="bill-plan-input"
                                    type="radio"
                                    name="plan_id"
                                    value="<?= $planId ?>"
                                    <?= $isChecked ? 'checked' : '' ?>
                                    <?= $index === 0 ? 'required' : '' ?>
                                >

                                <span class="bill-plan-tag <?= e($tierClass) ?>"><?= e($tierTag) ?></span>

                                <div class="bill-plan-top">
                                    <span class="bill-plan-name font-display"><?= e($planDisplayName) ?></span>
                                    <span class="bill-plan-price">
                                        <?php if ($isContactOnly): ?>
                                            Contact Sales
                                        <?php else: ?>
                                            <?= 'PHP ' . e(number_format((float) ($plan['price_amount'] ?? 0), 2)) ?>
                                            <small>/ quarter</small>
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <p><?= e((string) ($plan['description'] ?? '')) ?></p>

                                <ul>
                                    <?php foreach (array_slice($featureItems, 0, 4) as $feature): ?>
                                        <li><?= e(ucwords(str_replace('_', ' ', (string) $feature))) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="bill-form-row">
                        <label for="billing_cycle">Billing Cycle</label>
                        <select id="billing_cycle" name="billing_cycle">
                            <option value="quarterly" <?= $selectedCycleValue === 'quarterly' ? 'selected' : '' ?>>Quarterly</option>
                        </select>
                    </div>

                    <div class="bill-form-row">
                        <label for="test_mode">Checkout Test Mode</label>
                        <select id="test_mode" name="test_mode">
                            <option value="test_success">test_success (activate)</option>
                            <option value="test_pending">test_pending (awaiting payment)</option>
                            <option value="test_fail">test_fail (failed)</option>
                        </select>
                    </div>

                    <p class="bill-live-region" aria-live="polite"></p>

                    <button
                        class="bill-btn bill-btn-primary"
                        type="submit"
                        data-submit-label="<?= $isTestingMode ? 'Apply Plan and Simulate Checkout' : 'Run Test Checkout' ?>"
                        data-loading-label="Processing checkout..."
                    >
                        <?= $isTestingMode ? 'Apply Plan and Simulate Checkout' : 'Run Test Checkout' ?>
                    </button>
                </form>
            <?php endif; ?>
        </article>
    </section>

    <?php if ($canManage && $currentSubscription !== null && in_array((string) ($currentSubscription['status'] ?? ''), ['trialing', 'active', 'past_due'], true)): ?>
        <section class="bill-card bill-card-manage">
            <div class="bill-head">
                <h3>Admin billing actions</h3>
                <p>Cancel current subscription if needed.</p>
            </div>
            <form method="post" action="/billing/cancel" class="bill-manage-form">
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                <label for="cancel_reason">Cancellation reason (optional)</label>
                <input id="cancel_reason" type="text" name="cancel_reason" placeholder="Reason for cancellation">
                <button class="bill-btn bill-btn-danger" type="submit">Cancel Current Subscription</button>
            </form>
        </section>
    <?php endif; ?>

    <section class="bill-grid bill-grid-secondary">
        <article class="bill-card">
            <div class="bill-head">
                <h3>Recent checkout transactions</h3>
                <p>Latest simulated checkout attempts and outcomes.</p>
            </div>

            <div class="bill-table-wrap">
                <table class="bill-table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Plan</th>
                            <th>Mode</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($transactionRows === []): ?>
                            <tr>
                                <td colspan="5" class="bill-empty">No checkout transactions yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactionRows as $row): ?>
                                <tr>
                                    <td><?= e((string) ($row['reference_code'] ?? '-')) ?></td>
                                    <td><?= e((string) ($row['plan_name'] ?? '-')) ?></td>
                                    <td><?= e((string) ($row['test_mode'] ?? '-')) ?></td>
                                    <td>
                                        <span class="bill-pill bill-pill-<?= e((string) ($row['status'] ?? 'pending')) ?>">
                                            <?= e((string) strtoupper((string) ($row['status'] ?? 'pending'))) ?>
                                        </span>
                                    </td>
                                    <td><?= e((string) ($row['created_at'] ?? '-')) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </article>

        <article class="bill-card">
            <div class="bill-head">
                <h3>Subscription history</h3>
                <p>Recent lifecycle records for this company.</p>
            </div>

            <div class="bill-table-wrap">
                <table class="bill-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Start</th>
                            <th>End</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($historyRows === []): ?>
                            <tr>
                                <td colspan="4" class="bill-empty">No subscription history yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($historyRows as $row): ?>
                                <tr>
                                    <td><?= e((string) ($row['plan_name'] ?? '-')) ?></td>
                                    <td><?= e((string) ($row['status'] ?? '-')) ?></td>
                                    <td><?= e((string) ($row['starts_at'] ?? '-')) ?></td>
                                    <td><?= e((string) ($row['ends_at'] ?? '-')) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
</section>
