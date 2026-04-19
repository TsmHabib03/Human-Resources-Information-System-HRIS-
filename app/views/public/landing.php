<?php
$planRows      = is_array($plans ?? null) ? $plans : [];
$hasPlans      = $planRows !== [];
$isTestingMode = is_subscription_testing_mode();
$planCount     = max(1, count($planRows));

/* ── Data ──────────────────────────────────────────────────── */

$featureDefinitions = [
    [
        'name'         => 'Attendance tracking',
        'desc'         => 'Real-time clock-in and clock-out logging per employee with shift scheduling, overtime detection, and daily reconciliation against approved schedules.',
        'category'     => 'Attendance',
        'badge'        => 'mk-badge-attendance',
        'status'       => 'Live',
        'status_badge' => 'mk-badge-live',
    ],
    [
        'name'         => 'Leave management',
        'desc'         => 'Multi-type leave request workflow covering filing, manager approval, HR override, balance computation, and calendar blocking with automatic payroll deduction triggers.',
        'category'     => 'Leave',
        'badge'        => 'mk-badge-leave',
        'status'       => 'Live',
        'status_badge' => 'mk-badge-live',
    ],
    [
        'name'         => 'Payroll computation',
        'desc'         => 'End-to-end payroll run engine that calculates gross pay, statutory deductions (SSS, PhilHealth, Pag-IBIG, BIR), net pay, and generates per-employee payslips per cutoff.',
        'category'     => 'Payroll',
        'badge'        => 'mk-badge-payroll',
        'status'       => 'Live',
        'status_badge' => 'mk-badge-live',
    ],
    [
        'name'         => 'Employee records',
        'desc'         => 'Centralized employee profile database storing personal info, employment history, department assignments, job levels, salary grades, and document attachments.',
        'category'     => 'Core HR',
        'badge'        => 'mk-badge-core',
        'status'       => 'Live',
        'status_badge' => 'mk-badge-live',
    ],
    [
        'name'         => 'Onboarding workflow',
        'desc'         => 'Structured new-hire checklist that sequences document submission, credential provisioning, orientation scheduling, and probation tracking under HR and direct manager oversight.',
        'category'     => 'Core HR',
        'badge'        => 'mk-badge-core',
        'status'       => 'Beta',
        'status_badge' => 'mk-badge-beta',
    ],
    [
        'name'         => 'Role-based access',
        'desc'         => 'Permission layer that controls which modules, records, and actions each user can see or perform — enforced across every view based on assigned role and subscription plan coverage.',
        'category'     => 'Admin',
        'badge'        => 'mk-badge-admin',
        'status'       => 'Live',
        'status_badge' => 'mk-badge-live',
    ],
    [
        'name'         => 'Approval routing',
        'desc'         => 'Configurable multi-level approval chains for leave, overtime, reimbursements, and schedule changes — with escalation rules, deadline reminders, and full audit trails.',
        'category'     => 'Admin',
        'badge'        => 'mk-badge-admin',
        'status'       => 'Live',
        'status_badge' => 'mk-badge-live',
    ],
    [
        'name'         => 'Reporting and analytics',
        'desc'         => 'Pre-built and custom report builder covering headcount, attendance summaries, leave utilization, payroll cost breakdown, and compliance output for government filings.',
        'category'     => 'Admin',
        'badge'        => 'mk-badge-admin',
        'status'       => 'Planned',
        'status_badge' => 'mk-badge-planned',
    ],
];

$moduleMatrix = [
    ['module' => 'Attendance tracking',  'starter' => true,  'growth' => true,  'enterprise' => true],
    ['module' => 'Leave management',     'starter' => true,  'growth' => true,  'enterprise' => true],
    ['module' => 'Payroll computation',  'starter' => false, 'growth' => true,  'enterprise' => true],
    ['module' => 'Employee records',     'starter' => true,  'growth' => true,  'enterprise' => true],
    ['module' => 'Onboarding workflow',  'starter' => false, 'growth' => true,  'enterprise' => true],
    ['module' => 'Role-based access',    'starter' => true,  'growth' => true,  'enterprise' => true],
    ['module' => 'Approval routing',     'starter' => false, 'growth' => true,  'enterprise' => true],
    ['module' => 'Reporting / analytics','starter' => false, 'growth' => false, 'enterprise' => true],
];
?>

<div class="mk-shell mk-shell-landing">

    <!-- ── Top bar ──────────────────────────────────────────── -->
    <header class="mk-topbar" data-reveal style="--mk-delay: 0s;">

        <a class="mk-brand" href="/">
            <span class="mk-brand-dot" aria-hidden="true"></span>
            <span>
                <strong class="font-display">HRIS Cloud</strong>
                <small><?= $isTestingMode ? 'Testing Access Mode' : 'Production Billing Mode' ?></small>
            </span>
        </a>

        <nav class="mk-nav" aria-label="Main navigation">
            <a href="#features">Features</a>
            <a href="#modules">Modules</a>
            <a href="/pricing">Pricing</a>
            <a href="/login">Sign in</a>
            <a href="/pricing" class="mk-nav-cta">Start free</a>
        </nav>

    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <!-- ── Hero ─────────────────────────────────────────────── -->
    <section
        class="mk-hero-panel"
        aria-labelledby="mk-hero-title"
        data-reveal
        style="--mk-delay: .05s;"
    >
        <div class="mk-hero-main">

            <p class="mk-kicker">Daily Command Center</p>

            <h1 id="mk-hero-title" class="font-display">
                Run your HR operations from one dashboard-ready workspace.
            </h1>

            <p class="mk-hero-summary">
                <?= $isTestingMode
                    ? 'Select a plan, unlock modules by feature entitlement, and validate attendance, leave, and payroll flow in testing mode.'
                    : 'Move from onboarding to payroll with one consistent command layer where permissions, approvals, and billing stay aligned.' ?>
            </p>

            <div class="mk-hero-actions">
                <a href="/pricing" class="mk-btn mk-btn-primary">Start your plan</a>
                <a href="/login"   class="mk-btn mk-btn-muted">Open workspace</a>
            </div>

            <div class="mk-hero-tags" aria-label="Highlights">
                <span class="mk-hero-tag is-blue">Attendance Live</span>
                <span class="mk-hero-tag is-teal">Leave Workflow</span>
                <span class="mk-hero-tag is-coral">Payroll Queue</span>
            </div>

        </div>

        <aside class="mk-hero-side" aria-label="Platform summary">

            <p class="mk-side-label">Active plan tiers</p>
            <p class="mk-side-value"><?= e((string) $planCount) ?></p>
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

    <!-- ── Platform definitions table ────────────────────────── -->
    <section
        id="features"
        class="mk-definitions-panel"
        aria-labelledby="mk-definitions-title"
        data-reveal
        style="--mk-delay: .07s;"
    >
        <div class="mk-section-head">
            <p class="mk-kicker">Platform definitions</p>
            <h2 id="mk-definitions-title" class="font-display">What each part of the platform does</h2>
            <p>Every core workflow — defined clearly so your team knows what they're activating.</p>
        </div>

        <div class="mk-definitions-table-wrap">
            <table class="mk-definitions-table" aria-label="Platform feature definitions">
                <thead>
                    <tr>
                        <th scope="col">Feature</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($featureDefinitions as $def): ?>
                        <tr>
                            <th scope="row"><?= e($def['name']) ?></th>
                            <td><span class="mk-badge <?= e($def['badge']) ?>"><?= e($def['category']) ?></span></td>
                            <td><span class="mk-badge <?= e($def['status_badge']) ?>"><?= e($def['status']) ?></span></td>
                            <td class="mk-def-desc"><?= e($def['desc']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- ── Module access matrix ───────────────────────────────── -->
    <section
        id="modules"
        class="mk-modules-panel"
        aria-labelledby="mk-modules-title"
        data-reveal
        style="--mk-delay: .09s;"
    >
        <div class="mk-section-head">
            <p class="mk-kicker">Module access matrix</p>
            <h2 id="mk-modules-title" class="font-display">Which modules are included per plan</h2>
            <p>Feature availability by subscription tier — choose the coverage that fits your rollout.</p>
        </div>

        <div class="mk-modules-matrix" aria-label="Module access by plan">
            <div class="mk-matrix-header">
                <div class="mk-matrix-label">Module</div>
                <div class="mk-matrix-col">Starter</div>
                <div class="mk-matrix-col">Growth</div>
                <div class="mk-matrix-col">Enterprise</div>
            </div>

            <?php foreach ($moduleMatrix as $row): ?>
                <div class="mk-matrix-row">
                    <div class="mk-matrix-label"><?= e($row['module']) ?></div>
                    <?php foreach (['starter', 'growth', 'enterprise'] as $tier): ?>
                        <div class="mk-matrix-col">
                            <?php if ($row[$tier]): ?>
                                <span class="mk-check-icon" aria-label="Included" role="img">
                                    <svg viewBox="0 0 10 10" fill="none" aria-hidden="true">
                                        <polyline
                                            points="2,5 4.5,7.5 8,2.5"
                                            stroke="#16a34a"
                                            stroke-width="1.5"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </span>
                            <?php else: ?>
                                <span class="mk-dash-icon" aria-label="Not included" role="img">
                                    <span aria-hidden="true"></span>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="mk-footnote">
            Need detailed comparison? <a href="/pricing">Open full pricing and module matrix.</a>
        </p>
    </section>

    <!-- ── Final CTA ────────────────────────────────────────── -->
    <section
        class="mk-final-cta-panel"
        data-reveal
        style="--mk-delay: .11s;"
    >
        <div class="mk-cta-text">
            <p class="mk-kicker">Launch Fast</p>
            <h2 class="font-display">
                Move from disconnected tracking to one execution-ready HR workspace.
            </h2>
            <p>
                <?= $isTestingMode
                    ? 'Pick your plan, sign in, and validate feature-lock behavior before production cutover.'
                    : 'Pick your plan, sign in, and continue through production-ready subscription controls.' ?>
            </p>
        </div>
        <div class="mk-cta-actions">
            <a class="mk-btn mk-btn-primary" href="/pricing">Choose a plan</a>
            <a class="mk-btn mk-btn-muted"   href="/login">Go to sign in</a>
        </div>
    </section>

</div>