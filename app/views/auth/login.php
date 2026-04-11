<section class="auth-card">
    <h1>Welcome back</h1>
    <p>Sign in to access HRIS v1.</p>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <form method="post" action="/login" class="stack-md">
        <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

        <label for="identity">Username or Email</label>
        <input id="identity" name="identity" type="text" required autocomplete="username">

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">

        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>

    <small>Default seeded account: superadmin / Admin@123</small>
</section>
