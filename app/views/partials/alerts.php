<?php if (!empty($success ?? null)): ?>
    <div class="alert alert-success"><?= e((string) $success) ?></div>
<?php endif; ?>

<?php if (!empty($error ?? null)): ?>
    <div class="alert alert-danger"><?= e((string) $error) ?></div>
<?php endif; ?>

<?php if (!empty($errors ?? null) && is_array($errors)): ?>
    <div class="alert alert-danger">
        <ul class="inline-list">
            <?php foreach ($errors as $message): ?>
                <li><?= e((string) $message) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
