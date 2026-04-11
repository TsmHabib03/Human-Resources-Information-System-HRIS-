<section class="stack-md">
	<div class="page-actions">
		<h2>Employees</h2>
		<a class="btn btn-primary" href="/employees/create">Add Employee</a>
	</div>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<form class="inline-actions" method="get" action="/employees">
		<input type="text" name="q" value="<?= e((string) ($query ?? '')) ?>" placeholder="Search code, name, email, department">
		<select name="status">
			<option value="">All statuses</option>
			<?php foreach (($statusOptions ?? []) as $item): ?>
				<option value="<?= e((string) $item) ?>" <?= (($status ?? '') === $item) ? 'selected' : '' ?>><?= e((string) $item) ?></option>
			<?php endforeach; ?>
		</select>
		<button class="btn" type="submit">Filter</button>
	</form>

	<div class="table-wrap">
		<table class="table">
			<thead>
				<tr>
					<th>Code</th>
					<th>Name</th>
					<th>Department</th>
					<th>Designation</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($employees)): ?>
					<tr>
						<td colspan="6">No employees found.</td>
					</tr>
				<?php else: ?>
					<?php foreach ($employees as $employee): ?>
						<tr>
							<td><?= e((string) $employee['employee_code']) ?></td>
							<td><?= e((string) ($employee['first_name'] . ' ' . $employee['last_name'])) ?></td>
							<td><?= e((string) $employee['department_name']) ?></td>
							<td><?= e((string) $employee['designation_name']) ?></td>
							<td><span class="badge"><?= e((string) $employee['employment_status']) ?></span></td>
							<td class="actions-cell">
								<a href="/employees/<?= (int) $employee['id'] ?>">View</a>
								<a href="/employees/<?= (int) $employee['id'] ?>/edit">Edit</a>
								<form method="post" action="/employees/<?= (int) $employee['id'] ?>/delete" onsubmit="return confirm('Delete this employee?');">
									<input type="hidden" name="_csrf" value="<?= e(App\Core\CSRF::token()) ?>">
									<button type="submit" class="btn-link danger">Delete</button>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<?php if (($totalPages ?? 1) > 1): ?>
		<?php $base = '/employees?q=' . urlencode((string) ($query ?? '')) . '&status=' . urlencode((string) ($status ?? '')) . '&page='; ?>
		<nav class="pagination">
			<?php for ($i = 1; $i <= (int) $totalPages; $i++): ?>
				<a class="page-link <?= ((int) ($page ?? 1) === $i) ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
			<?php endfor; ?>
		</nav>
	<?php endif; ?>
</section>
