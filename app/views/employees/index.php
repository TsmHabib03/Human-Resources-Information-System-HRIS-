<?php
$employeeRows = is_array($employees ?? null) ? $employees : [];
$currentQuery = (string) ($query ?? '');
$currentStatus = (string) ($status ?? '');
$statusList = is_array($statusOptions ?? null) ? $statusOptions : [];
$currentPage = (int) ($page ?? 1);
$pageCount = (int) ($totalPages ?? 1);
$totalCount = (int) ($total ?? 0);
$canCreateEmployee = can('employees.create');
$canUpdateEmployee = can('employees.update');
$canDeleteEmployee = can('employees.delete');

$statusClassMap = [
	'active' => 'emp-badge-active',
	'probation' => 'emp-badge-probation',
	'on_leave' => 'emp-badge-on_leave',
	'resigned' => 'emp-badge-resigned',
	'terminated' => 'emp-badge-terminated',
];
?>

<section class="emp-page">
	<header class="emp-hero">
		<div class="emp-hero-copy">
			<p class="emp-kicker">Employee Directory</p>
			<h2 class="emp-title font-display">Workforce records in one focused view</h2>
			<p class="emp-subtitle">Search by employee code, name, department, or status and take action without leaving the list.</p>
			<div class="emp-tags">
				<span class="emp-tag">Live roster</span>
				<span class="emp-tag">Role-based access</span>
				<span class="emp-tag">Audit friendly actions</span>
			</div>
		</div>

		<div class="emp-hero-side">
			<div class="emp-stat">
				<span class="emp-stat-label">Records found</span>
				<span class="emp-stat-value"><?= e((string) $totalCount) ?></span>
			</div>
			<div class="emp-hero-actions">
				<a class="emp-action-link" href="/employees">Refresh list</a>
				<?php if ($canCreateEmployee): ?>
					<a class="emp-action-primary" href="/employees/create">Add employee</a>
				<?php endif; ?>
			</div>
		</div>
	</header>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<section class="emp-surface">
		<div class="emp-toolbar">
			<form class="emp-filter-form" method="get" action="/employees">
				<label class="emp-filter-field">
					<span>Search</span>
					<input type="text" name="q" value="<?= e($currentQuery) ?>" placeholder="Code, name, email, department">
				</label>

				<label class="emp-filter-field">
					<span>Status</span>
					<select name="status">
						<option value="">All statuses</option>
						<?php foreach ($statusList as $item): ?>
							<option value="<?= e((string) $item) ?>" <?= $currentStatus === $item ? 'selected' : '' ?>><?= e((string) $item) ?></option>
						<?php endforeach; ?>
					</select>
				</label>

				<button class="emp-filter-btn" type="submit">Apply filters</button>
			</form>
		</div>

		<div class="emp-table-wrap">
			<table class="emp-table">
				<thead>
					<tr>
						<th>Employee</th>
						<th>Department</th>
						<th>Designation</th>
						<th>Status</th>
						<th>Contact</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($employeeRows === []): ?>
						<tr>
							<td colspan="6">
								<p class="emp-empty">No employees found for the current filters.</p>
							</td>
						</tr>
					<?php else: ?>
						<?php foreach ($employeeRows as $employee): ?>
							<?php
							$statusValue = (string) ($employee['employment_status'] ?? 'Unknown');
							$statusKey = strtolower(str_replace([' ', '-'], '_', $statusValue));
							$statusClass = $statusClassMap[$statusKey] ?? 'emp-badge-default';
							$name = trim((string) (($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? '')));
							?>
							<tr>
								<td>
									<div class="emp-name">
										<strong><?= e($name !== '' ? $name : 'Unknown employee') ?></strong>
										<span><?= e((string) ($employee['employee_code'] ?? '-')) ?></span>
									</div>
								</td>
								<td><?= e((string) ($employee['department_name'] ?? '-')) ?></td>
								<td><?= e((string) ($employee['designation_name'] ?? '-')) ?></td>
								<td><span class="emp-badge <?= e($statusClass) ?>"><?= e($statusValue) ?></span></td>
								<td><?= e((string) ($employee['email'] ?? '-')) ?></td>
								<td>
									<div class="emp-row-actions">
										<a href="/employees/<?= (int) ($employee['id'] ?? 0) ?>">View</a>
										<?php if ($canUpdateEmployee): ?>
											<a href="/employees/<?= (int) ($employee['id'] ?? 0) ?>/edit">Edit</a>
										<?php endif; ?>
										<?php if ($canDeleteEmployee): ?>
											<form method="post" action="/employees/<?= (int) ($employee['id'] ?? 0) ?>/delete" onsubmit="return confirm('Delete this employee?');">
												<input type="hidden" name="_csrf" value="<?= e(App\Core\CSRF::token()) ?>">
												<button type="submit" class="btn-link danger">Delete</button>
											</form>
										<?php endif; ?>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

		<?php if ($pageCount > 1): ?>
			<?php $base = '/employees?q=' . urlencode($currentQuery) . '&status=' . urlencode($currentStatus) . '&page='; ?>
			<nav class="emp-pagination">
				<?php for ($i = 1; $i <= $pageCount; $i++): ?>
					<a class="emp-page-link <?= $currentPage === $i ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
				<?php endfor; ?>
			</nav>
		<?php endif; ?>
	</section>
</section>
