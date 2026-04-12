<?php
$gradeRows = is_array($grades ?? null) ? $grades : [];
$employeeOptions = is_array($employees ?? null) ? $employees : [];
$salaryRows = is_array($salaries ?? null) ? $salaries : [];
$oldInput = is_array($old ?? null) ? $old : [];

$currentQuery = (string) ($query ?? '');
$currentPage = (int) ($page ?? 1);
$pageCount = (int) ($totalPages ?? 1);
$totalCount = (int) ($total ?? 0);

$currentSalaryCount = 0;
foreach ($salaryRows as $salary) {
    if ((int) ($salary['is_current'] ?? 0) === 1) {
        $currentSalaryCount++;
    }
}
?>

<section class="pay-page">
    <header class="pay-hero">
        <div class="pay-hero-copy">
            <p class="pay-kicker">Payroll</p>
            <h2 class="pay-title font-display">Compensation setup and salary records</h2>
            <p class="pay-subtitle">Manage salary grades, assign employee salaries, and review effective pay history from one streamlined page.</p>
            <div class="pay-tags">
                <span class="pay-tag">Salary grades</span>
                <span class="pay-tag">Current flag tracking</span>
                <span class="pay-tag">History-aware records</span>
            </div>
        </div>

        <aside class="pay-hero-side">
            <article class="pay-stat">
                <span class="pay-stat-label">Records</span>
                <span class="pay-stat-value"><?= e((string) $totalCount) ?></span>
            </article>
            <article class="pay-stat">
                <span class="pay-stat-label">Current on page</span>
                <span class="pay-stat-value"><?= e((string) $currentSalaryCount) ?></span>
            </article>
            <article class="pay-stat">
                <span class="pay-stat-label">Salary grades</span>
                <span class="pay-stat-value"><?= e((string) count($gradeRows)) ?></span>
            </article>
        </aside>
    </header>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <section class="pay-grid">
        <article class="pay-card">
            <div class="pay-section-head">
                <h3>Salary Grades</h3>
                <p>Create or update salary ranges by grade name.</p>
            </div>

            <form class="pay-inline-form" method="post" action="/payroll/grades">
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
                <input type="text" name="grade_name" value="<?= e((string) ($oldInput['grade_name'] ?? '')) ?>" placeholder="Grade name" required>
                <input type="number" step="0.01" name="min_salary" value="<?= e((string) ($oldInput['min_salary'] ?? '')) ?>" placeholder="Min salary" required>
                <input type="number" step="0.01" name="max_salary" value="<?= e((string) ($oldInput['max_salary'] ?? '')) ?>" placeholder="Max salary" required>
                <button class="pay-btn-primary" type="submit">Save grade</button>
            </form>

            <div class="pay-table-wrap">
                <table class="pay-table">
                    <thead>
                        <tr>
                            <th>Grade</th>
                            <th>Min</th>
                            <th>Max</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($gradeRows === []): ?>
                            <tr>
                                <td colspan="3"><p class="pay-empty">No salary grades found.</p></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($gradeRows as $grade): ?>
                                <tr>
                                    <td><?= e((string) ($grade['grade_name'] ?? '-')) ?></td>
                                    <td><?= e((string) ($grade['min_salary'] ?? '-')) ?></td>
                                    <td><?= e((string) ($grade['max_salary'] ?? '-')) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </article>

        <article class="pay-card">
            <div class="pay-section-head">
                <h3>Assign Employee Salary</h3>
                <p>Create a salary record and optionally mark it as the current salary.</p>
            </div>

            <form class="pay-form-grid" method="post" action="/payroll/salaries">
                <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

                <div class="pay-field">
                    <label for="employee_id">Employee</label>
                    <select id="employee_id" name="employee_id" required>
                        <option value="">Select</option>
                        <?php foreach ($employeeOptions as $employee): ?>
                            <option value="<?= (int) $employee['id'] ?>" <?= ((string) ($oldInput['employee_id'] ?? '') === (string) $employee['id']) ? 'selected' : '' ?>>
                                <?= e((string) ($employee['employee_code'] . ' - ' . $employee['first_name'] . ' ' . $employee['last_name'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="pay-field">
                    <label for="salary_grade_id">Salary Grade</label>
                    <select id="salary_grade_id" name="salary_grade_id">
                        <option value="">None</option>
                        <?php foreach ($gradeRows as $grade): ?>
                            <option value="<?= (int) $grade['id'] ?>" <?= ((string) ($oldInput['salary_grade_id'] ?? '') === (string) $grade['id']) ? 'selected' : '' ?>>
                                <?= e((string) $grade['grade_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="pay-field">
                    <label for="basic_salary">Basic Salary</label>
                    <input id="basic_salary" type="number" step="0.01" name="basic_salary" value="<?= e((string) ($oldInput['basic_salary'] ?? '')) ?>" required>
                </div>

                <div class="pay-field">
                    <label for="effective_date">Effective Date</label>
                    <input id="effective_date" type="date" name="effective_date" value="<?= e((string) ($oldInput['effective_date'] ?? '')) ?>" required>
                </div>

                <div class="pay-field">
                    <label for="is_current">Set as Current</label>
                    <select id="is_current" name="is_current">
                        <option value="1" <?= (($oldInput['is_current'] ?? '1') === '1') ? 'selected' : '' ?>>Yes</option>
                        <option value="0" <?= (($oldInput['is_current'] ?? '1') === '0') ? 'selected' : '' ?>>No</option>
                    </select>
                </div>

                <div class="pay-field full pay-form-actions">
                    <p class="pay-form-hint">If set as current, older salary records for the employee are automatically unset.</p>
                    <button class="pay-btn-primary" type="submit">Save employee salary</button>
                </div>
            </form>
        </article>
    </section>

    <section class="pay-card pay-search">
        <div class="pay-section-head">
            <h3>Salary Records</h3>
            <p>Search by employee code, name, or grade to find salary records quickly.</p>
        </div>

        <form class="pay-search-form" method="get" action="/payroll">
            <input type="text" name="q" value="<?= e($currentQuery) ?>" placeholder="Search employee or grade">
            <button class="pay-search-btn" type="submit">Search</button>
        </form>

        <div class="pay-table-wrap">
            <table class="pay-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Grade</th>
                        <th>Basic Salary</th>
                        <th>Effective Date</th>
                        <th>Current</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($salaryRows === []): ?>
                        <tr>
                            <td colspan="5"><p class="pay-empty">No salary records found.</p></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($salaryRows as $salary): ?>
                            <tr>
                                <td>
                                    <div class="pay-name">
                                        <strong><?= e((string) (($salary['first_name'] ?? '') . ' ' . ($salary['last_name'] ?? ''))) ?></strong>
                                        <span><?= e((string) ($salary['employee_code'] ?? '-')) ?></span>
                                    </div>
                                </td>
                                <td><?= e((string) ($salary['grade_name'] ?? '-')) ?></td>
                                <td><?= e((string) ($salary['basic_salary'] ?? '-')) ?></td>
                                <td><?= e((string) ($salary['effective_date'] ?? '-')) ?></td>
                                <td>
                                    <span class="pay-badge <?= ((int) ($salary['is_current'] ?? 0) === 1) ? 'pay-badge-current' : 'pay-badge-historical' ?>">
                                        <?= ((int) ($salary['is_current'] ?? 0) === 1) ? 'Current' : 'Historical' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pageCount > 1): ?>
            <?php $base = '/payroll?q=' . urlencode($currentQuery) . '&page='; ?>
            <nav class="pay-pagination">
                <?php for ($i = 1; $i <= $pageCount; $i++): ?>
                    <a class="pay-page-link <?= $currentPage === $i ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>
    </section>
</section>
