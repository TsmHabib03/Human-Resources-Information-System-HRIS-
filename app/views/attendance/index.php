<section class="stack-md">
	<h2>Attendance</h2>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<form class="form-grid" method="post" action="/attendance">
		<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

		<label>Employee
			<select name="employee_id" required>
				<option value="">Select</option>
				<?php foreach (($employees ?? []) as $employee): ?>
					<option value="<?= (int) $employee['id'] ?>" <?= ((int) (($old['employee_id'] ?? 0)) === (int) $employee['id']) ? 'selected' : '' ?>>
						<?= e((string) ($employee['employee_code'] . ' - ' . $employee['first_name'] . ' ' . $employee['last_name'])) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Date<input type="date" name="date" value="<?= e((string) (($old['date'] ?? ($date ?? date('Y-m-d'))))) ?>" required></label>
		<label>Status
			<select name="status" required>
				<?php foreach (($statusOptions ?? []) as $item): ?>
					<option value="<?= e((string) $item) ?>" <?= (($old['status'] ?? 'Present') === $item) ? 'selected' : '' ?>><?= e((string) $item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Clock In<input type="datetime-local" name="clock_in" value="<?= e(str_replace(' ', 'T', (string) ($old['clock_in'] ?? ''))) ?>"></label>
		<label>Clock Out<input type="datetime-local" name="clock_out" value="<?= e(str_replace(' ', 'T', (string) ($old['clock_out'] ?? ''))) ?>"></label>
		<label>Hours Worked<input type="number" step="0.01" name="hours_worked" value="<?= e((string) ($old['hours_worked'] ?? '')) ?>"></label>
		<label>Overtime Hours<input type="number" step="0.01" name="overtime_hrs" value="<?= e((string) ($old['overtime_hrs'] ?? '0')) ?>"></label>
		<label class="full-width">Remarks<textarea name="remarks" rows="2"><?= e((string) ($old['remarks'] ?? '')) ?></textarea></label>

		<div class="full-width">
			<button class="btn btn-primary" type="submit">Save Attendance</button>
		</div>
	</form>

	<form method="get" action="/attendance" class="inline-actions">
		<input type="text" name="q" value="<?= e((string) ($query ?? '')) ?>" placeholder="Search employee">
		<label>View Date <input type="date" name="date" value="<?= e((string) ($date ?? date('Y-m-d'))) ?>"></label>
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
					<th>Employee</th>
					<th>Date</th>
					<th>Status</th>
					<th>Clock In</th>
					<th>Clock Out</th>
					<th>Hours</th>
					<th>OT</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($records)): ?>
					<tr><td colspan="7">No attendance records for selected date.</td></tr>
				<?php else: ?>
					<?php foreach ($records as $record): ?>
						<tr>
							<td><?= e((string) ($record['employee_code'] . ' - ' . $record['first_name'] . ' ' . $record['last_name'])) ?></td>
							<td><?= e((string) $record['date']) ?></td>
							<td><span class="badge"><?= e((string) $record['status']) ?></span></td>
							<td><?= e((string) ($record['clock_in'] ?? '-')) ?></td>
							<td><?= e((string) ($record['clock_out'] ?? '-')) ?></td>
							<td><?= e((string) ($record['hours_worked'] ?? '-')) ?></td>
							<td><?= e((string) ($record['overtime_hrs'] ?? '0')) ?></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<?php if (($totalPages ?? 1) > 1): ?>
		<?php $base = '/attendance?date=' . urlencode((string) ($date ?? date('Y-m-d'))) . '&q=' . urlencode((string) ($query ?? '')) . '&status=' . urlencode((string) ($status ?? '')) . '&page='; ?>
		<nav class="pagination">
			<?php for ($i = 1; $i <= (int) $totalPages; $i++): ?>
				<a class="page-link <?= ((int) ($page ?? 1) === $i) ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
			<?php endfor; ?>
		</nav>
	<?php endif; ?>
</section>
