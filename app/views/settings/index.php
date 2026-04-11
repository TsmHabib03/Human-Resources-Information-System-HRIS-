<section class="stack-md">
    <h2>Settings</h2>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <div class="widget">
        <h3>Company Profile</h3>
        <form class="form-grid" method="post" action="/settings/company">
            <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

            <label>Company Name
                <input type="text" name="company_name" value="<?= e((string) (($company['company_name'] ?? ''))) ?>" required>
            </label>

            <label>Email
                <input type="email" name="email" value="<?= e((string) (($company['email'] ?? ''))) ?>">
            </label>

            <label>Phone
                <input type="text" name="phone" value="<?= e((string) (($company['phone'] ?? ''))) ?>">
            </label>

            <label>Website
                <input type="text" name="website" value="<?= e((string) (($company['website'] ?? ''))) ?>">
            </label>

            <label>Logo Path
                <input type="text" name="logo_path" value="<?= e((string) (($company['logo_path'] ?? ''))) ?>">
            </label>

            <label class="full-width">Address
                <textarea name="address" rows="3"><?= e((string) (($company['address'] ?? ''))) ?></textarea>
            </label>

            <div class="full-width">
                <button class="btn btn-primary" type="submit">Save Company</button>
            </div>
        </form>
    </div>

    <div class="widget">
        <h3>System Preferences</h3>
        <form class="inline-actions" method="post" action="/settings/system">
            <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
            <input type="text" name="timezone" value="<?= e((string) (($system['timezone'] ?? 'Asia/Manila'))) ?>" placeholder="Timezone" required>
            <input type="text" name="date_format" value="<?= e((string) (($system['date_format'] ?? 'Y-m-d'))) ?>" placeholder="Date format" required>
            <input type="text" name="default_currency" value="<?= e((string) (($system['default_currency'] ?? 'PHP'))) ?>" placeholder="Currency" required>
            <button class="btn btn-primary" type="submit">Save System</button>
        </form>
    </div>

    <div class="widget">
        <h3>Roles</h3>
        <div class="table-wrap">
            <table class="table">
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
                    <?php if (empty($roles)): ?>
                        <tr><td colspan="5">No roles found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><?= e((string) $role['role_name']) ?></td>
                                <td><?= e((string) ($role['description'] ?? '-')) ?></td>
                                <td><?= (int) $role['permission_count'] ?></td>
                                <td><span class="badge"><?= ((int) $role['is_active'] === 1) ? 'Active' : 'Inactive' ?></span></td>
                                <td>
                                    <form method="post" action="/settings/roles/<?= (int) $role['id'] ?>/toggle">
                                        <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                                        <button class="btn-link" type="submit">Toggle</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
