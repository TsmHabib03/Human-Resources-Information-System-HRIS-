<section class="stack-md">
    <h2>Payroll</h2>

    <?php require __DIR__ . '/../partials/alerts.php'; ?>

    <div class="widget">
        <h3>Salary Grades</h3>
        <form class="inline-actions" method="post" action="/payroll/grades">
            <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
            <input type="text" name="grade_name" placeholder="Grade name" required>
            <input type="number" step="0.01" name="min_salary" placeholder="Min salary" required>
            <input type="number" step="0.01" name="max_salary" placeholder="Max salary" required>
            <button class="btn btn-primary" type="submit">Save Grade</button>
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Grade</th>
                        <th>Min</th>
                        <th>Max</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($grades)): ?>
                        <tr><td colspan="3">No salary grades found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($grades as $grade): ?>
                            <tr>
                                <td><?= e((string) $grade['grade_name']) ?></td>
                                <td><?= e((string) $grade['min_salary']) ?></td>
                                <td><?= e((string) $grade['max_salary']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="widget">
        <h3>Assign Employee Salary</h3>
        <form class="form-grid" method="post" action="/payroll/salaries">
            <input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

            <label>Employee
                <select name="employee_id" required>
                    <option value="">Select</option>
                    <?php foreach (($employees ?? []) as $employee): ?>
                        <option value="<?= (int) $employee['id'] ?>"><?= e((string) ($employee['employee_code'] . ' - ' . $employee['first_name'] . ' ' . $employee['last_name'])) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>Salary Grade
                <select name="salary_grade_id">
                    <option value="">None</option>
                    <?php foreach (($grades ?? []) as $grade): ?>
                        <option value="<?= (int) $grade['id'] ?>"><?= e((string) $grade['grade_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>Basic Salary
                <input type="number" step="0.01" name="basic_salary" required>
            </label>

            <label>Effective Date
                <input type="date" name="effective_date" required>
            </label>

            <label>Set as Current
                <select name="is_current">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </label>

            <div class="full-width">
                <button class="btn btn-primary" type="submit">Save Employee Salary</button>
            </div>
        </form>
    </div>

    <form class="inline-actions" method="get" action="/payroll">
        <input type="text" name="q" value="<?= e((string) ($query ?? '')) ?>" placeholder="Search employee or grade">
        <button class="btn" type="submit">Search</button>
    </form>

    <div class="table-wrap">
        <table class="table">
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
                <?php if (empty($salaries)): ?>
                    <tr><td colspan="5">No salary records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($salaries as $salary): ?>
                        <tr>
                            <td><?= e((string) ($salary['employee_code'] . ' - ' . $salary['first_name'] . ' ' . $salary['last_name'])) ?></td>
                            <td><?= e((string) ($salary['grade_name'] ?? '-')) ?></td>
                            <td><?= e((string) $salary['basic_salary']) ?></td>
                            <td><?= e((string) $salary['effective_date']) ?></td>
                            <td><span class="badge"><?= ((int) $salary['is_current'] === 1) ? 'Yes' : 'No' ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (($totalPages ?? 1) > 1): ?>
        <?php $base = '/payroll?q=' . urlencode((string) ($query ?? '')) . '&page='; ?>
        <nav class="pagination">
            <?php for ($i = 1; $i <= (int) $totalPages; $i++): ?>
                <a class="page-link <?= ((int) ($page ?? 1) === $i) ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</section>
