<?php
$company = is_array($company ?? null) ? $company : [];
$system = is_array($system ?? null) ? $system : [];
$roleRows = is_array($roles ?? null) ? $roles : [];
$superAdminOnlyMode = super_admin_only_mode_enabled();

if ($superAdminOnlyMode) {
    $roleRows = array_values(array_filter($roleRows, static function (array $role): bool {
        return (string) ($role['role_name'] ?? '') === 'Super Admin';
    }));
}

$activeRoles = 0;
$inactiveRoles = 0;
foreach ($roleRows as $role) {
    if ((int) ($role['is_active'] ?? 0) === 1) {
        $activeRoles++;
    } else {
        $inactiveRoles++;
    }
}
?>

<section class="set-page">
    <header class="set-hero">
        <div class="set-hero-copy">
            <p class="set-kicker">Settings</p>
            <h2 class="set-title font-display">Configure company, system, and role controls</h2>
            <p class="set-subtitle">Maintain organization details, global preferences, and role activation from a single admin control panel.</p>
            <div class="set-tags">
                <span class="set-tag">Company profile</span>
                <span class="set-tag">System preferences</span>
                <span class="set-tag">Role lifecycle</span>
            </div>
        </div>

        <aside class="set-hero-side">
            <article class="set-stat">
                <span class="set-stat-label">Total roles</span>
                <span class="set-stat-value"><?= e((string) count($roleRows)) ?></span>
            </article>
            <article class="set-stat">
                <span class="set-stat-label">Active roles</span>
                <span class="set-stat-value"><?= e((string) $activeRoles) ?></span>
            </article>
            <article class="set-stat">
                <span class="set-stat-label">Inactive roles</span>
                <span class="set-stat-value"><?= e((string) $inactiveRoles) ?></span>
            </article>
        </aside>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="set-grid">
        <article class="set-card">
            <div class="set-section-head">
                <h3>Company Profile</h3>
                <p>Update organization identity and contact details used across the system.</p>
            </div>

            <form class="set-form-grid" method="post" action="/settings/company">
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

                <div class="set-field">
                    <label for="company_name">Company Name</label>
                    <input id="company_name" type="text" name="company_name" value="<?= e((string) ($company['company_name'] ?? '')) ?>" required>
                </div>

                <div class="set-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?= e((string) ($company['email'] ?? '')) ?>">
                </div>

                <div class="set-field">
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" name="phone" value="<?= e((string) ($company['phone'] ?? '')) ?>">
                </div>

                <div class="set-field">
                    <label for="website">Website</label>
                    <input id="website" type="text" name="website" value="<?= e((string) ($company['website'] ?? '')) ?>">
                </div>

                <div class="set-field">
                    <label for="logo_path">Logo Path</label>
                    <input id="logo_path" type="text" name="logo_path" value="<?= e((string) ($company['logo_path'] ?? '')) ?>">
                </div>

                <div class="set-field full">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"><?= e((string) ($company['address'] ?? '')) ?></textarea>
                </div>

                <div class="set-field full set-form-actions">
                    <p class="set-form-hint">Company name is required. Email format is validated on submit.</p>
                    <button class="set-btn-primary" type="submit">Save company</button>
                </div>
            </form>
        </article>

        <article class="set-card">
            <div class="set-section-head">
                <h3>System Preferences</h3>
                <p>Configure global timezone, date format, and default currency settings.</p>
            </div>

            <form class="set-system-form" method="post" action="/settings/system">
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                <input type="text" name="timezone" value="<?= e((string) ($system['timezone'] ?? 'Asia/Manila')) ?>" placeholder="Timezone" required>
                <input type="text" name="date_format" value="<?= e((string) ($system['date_format'] ?? 'Y-m-d')) ?>" placeholder="Date format" required>
                <input type="text" name="default_currency" value="<?= e((string) ($system['default_currency'] ?? 'PHP')) ?>" placeholder="Currency" required>
                <button class="set-btn-primary" type="submit">Save system</button>
            </form>
        </article>

        <article class="set-card">
            <div class="set-section-head">
                <h3>Roles</h3>
                <p>
                    <?= $superAdminOnlyMode
                        ? 'Super Admin-only mode is enabled. Other actor roles are hidden and cannot be reactivated from this panel.'
                        : 'Review permission counts and toggle role availability.' ?>
                </p>
            </div>

            <div class="set-table-wrap">
                <table class="set-table">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($roleRows === []): ?>
                            <tr>
                                <td colspan="5"><p class="set-empty">No roles found.</p></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($roleRows as $role): ?>
                                <tr>
                                    <td>
                                        <div class="set-role">
                                            <strong><?= e((string) ($role['role_name'] ?? '-')) ?></strong>
                                            <span>ID: <?= e((string) ($role['id'] ?? '-')) ?></span>
                                        </div>
                                    </td>
                                    <td><?= e((string) ($role['description'] ?? '-')) ?></td>
                                    <td><?= e((string) ((int) ($role['permission_count'] ?? 0))) ?></td>
                                    <td>
                                        <span class="set-badge <?= ((int) ($role['is_active'] ?? 0) === 1) ? 'set-badge-active' : 'set-badge-inactive' ?>">
                                            <?= ((int) ($role['is_active'] ?? 0) === 1) ? 'Active' : 'Inactive' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($superAdminOnlyMode): ?>
                                            <span class="set-badge set-badge-inactive">Locked by mode</span>
                                        <?php else: ?>
                                            <form method="post" action="/settings/roles/<?= (int) ($role['id'] ?? 0) ?>/toggle">
                                                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                                                <button class="set-toggle-btn" type="submit">Toggle status</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
</section>
