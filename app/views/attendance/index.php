<?php
$attendanceRecords = is_array($records ?? null) ? $records : [];
$employeeOptions = is_array($employees ?? null) ? $employees : [];
$statusList = is_array($statusOptions ?? null) ? $statusOptions : [];
$oldInput = is_array($old ?? null) ? $old : [];

$currentDate = (string) ($date ?? date('Y-m-d'));
$currentQuery = (string) ($query ?? '');
$currentStatus = (string) ($status ?? '');
$currentPage = (int) ($page ?? 1);
$pageCount = (int) ($totalPages ?? 1);
$totalCount = (int) ($total ?? 0);
$canManageAttendance = can('attendance.manage');

$presentCount = 0;
$lateCount = 0;
$absentCount = 0;

foreach ($attendanceRecords as $entry) {
	$entryStatus = (string) ($entry['status'] ?? '');
	if ($entryStatus === 'Present') {
		$presentCount++;
	} elseif ($entryStatus === 'Late') {
		$lateCount++;
	} elseif ($entryStatus === 'Absent') {
		$absentCount++;
	}
}

$statusClassMap = [
	'present' => 'att-badge-present',
	'late' => 'att-badge-late',
	'absent' => 'att-badge-absent',
	'half_day' => 'att-badge-half_day',
	'holiday' => 'att-badge-holiday',
	'rest_day' => 'att-badge-rest_day',
];
?>

<section class="att-page">
	<header class="att-hero">
		<div class="att-hero-copy">
			<p class="att-kicker">Attendance</p>
			<h2 class="att-title font-display">Track daily attendance with operational clarity</h2>
			<p class="att-subtitle">Record employee attendance and review daily trends in one focused workspace.</p>
			<div class="att-tags">
				<span class="att-tag">Daily record</span>
				<span class="att-tag">Status aware</span>
				<span class="att-tag">Timesheet ready</span>
			</div>
		</div>

		<aside class="att-hero-side">
			<article class="att-stat">
				<span class="att-stat-label">Total records</span>
				<span class="att-stat-value"><?= e((string) $totalCount) ?></span>
			</article>
			<article class="att-stat">
				<span class="att-stat-label">Present</span>
				<span class="att-stat-value"><?= e((string) $presentCount) ?></span>
			</article>
			<article class="att-stat">
				<span class="att-stat-label">Late / Absent</span>
				<span class="att-stat-value"><?= e((string) ($lateCount + $absentCount)) ?></span>
			</article>
		</aside>
	</header>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<?php if ($canManageAttendance): ?>
		<section class="att-card">
			<div class="att-section-head">
				<h3>Record Attendance</h3>
				<p>Submit clock details and status for an employee on a specific date.</p>
			</div>

			<form class="att-form-grid" method="post" action="/attendance">
				<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

				<div class="att-field">
					<label for="employee_id">Employee</label>
					<select id="employee_id" name="employee_id" required>
						<option value="">Select</option>
						<?php foreach ($employeeOptions as $employee): ?>
							<option value="<?= (int) $employee['id'] ?>" <?= ((int) ($oldInput['employee_id'] ?? 0) === (int) $employee['id']) ? 'selected' : '' ?>>
								<?= e((string) ($employee['employee_code'] . ' - ' . $employee['first_name'] . ' ' . $employee['last_name'])) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="att-field">
					<label for="date">Date</label>
					<input id="date" type="date" name="date" value="<?= e((string) ($oldInput['date'] ?? $currentDate)) ?>" required>
				</div>

				<div class="att-field">
					<label for="status">Status</label>
					<select id="status" name="status" required>
						<?php foreach ($statusList as $item): ?>
							<option value="<?= e((string) $item) ?>" <?= (($oldInput['status'] ?? 'Present') === $item) ? 'selected' : '' ?>><?= e((string) $item) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="att-field">
					<label for="clock_in">Clock In</label>
					<input id="clock_in" type="datetime-local" name="clock_in" value="<?= e(str_replace(' ', 'T', (string) ($oldInput['clock_in'] ?? ''))) ?>">
				</div>

				<div class="att-field">
					<label for="clock_out">Clock Out</label>
					<input id="clock_out" type="datetime-local" name="clock_out" value="<?= e(str_replace(' ', 'T', (string) ($oldInput['clock_out'] ?? ''))) ?>">
				</div>

				<div class="att-field">
					<label for="hours_worked">Hours Worked</label>
					<input id="hours_worked" type="number" step="0.01" name="hours_worked" value="<?= e((string) ($oldInput['hours_worked'] ?? '')) ?>">
				</div>

				<div class="att-field">
					<label for="overtime_hrs">Overtime Hours</label>
					<input id="overtime_hrs" type="number" step="0.01" name="overtime_hrs" value="<?= e((string) ($oldInput['overtime_hrs'] ?? '0')) ?>">
				</div>

				<div class="att-field full">
					<label for="remarks">Remarks</label>
					<textarea id="remarks" name="remarks" rows="2"><?= e((string) ($oldInput['remarks'] ?? '')) ?></textarea>
				</div>

				<div class="att-field full att-form-actions">
					<p class="att-form-hint">Leave hours blank to auto-calculate from clock in/out.</p>
					<button class="att-btn-primary" type="submit">Save attendance</button>
				</div>
			</form>
		</section>
	<?php endif; ?>

	<section class="att-card att-toolbar">
		<div class="att-section-head">
			<h3>Attendance Records</h3>
			<p>Filter by employee, date, and status to review daily attendance snapshots.</p>
		</div>

		<form method="get" action="/attendance" class="att-filter-form">
			<label class="att-filter-field">
				<span>Search</span>
				<input type="text" name="q" value="<?= e($currentQuery) ?>" placeholder="Search employee">
			</label>

			<label class="att-filter-field">
				<span>Date</span>
				<input type="date" name="date" value="<?= e($currentDate) ?>">
			</label>

			<label class="att-filter-field">
				<span>Status</span>
				<select name="status">
					<option value="">All statuses</option>
					<?php foreach ($statusList as $item): ?>
						<option value="<?= e((string) $item) ?>" <?= ($currentStatus === $item) ? 'selected' : '' ?>><?= e((string) $item) ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<button class="att-filter-btn" type="submit">Apply filters</button>
		</form>

		<div class="att-table-wrap">
			<table class="att-table">
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
					<?php if ($attendanceRecords === []): ?>
						<tr>
							<td colspan="7">
								<p class="att-empty">No attendance records for the selected filters.</p>
							</td>
						</tr>
					<?php else: ?>
						<?php foreach ($attendanceRecords as $record): ?>
							<?php
							$statusValue = (string) ($record['status'] ?? 'Unknown');
							$statusKey = strtolower(str_replace([' ', '-'], '_', $statusValue));
							$statusClass = $statusClassMap[$statusKey] ?? 'att-badge-default';
							?>
							<tr>
								<td>
									<div class="att-name">
										<strong><?= e((string) (($record['first_name'] ?? '') . ' ' . ($record['last_name'] ?? ''))) ?></strong>
										<span><?= e((string) ($record['employee_code'] ?? '-')) ?></span>
									</div>
								</td>
								<td><?= e((string) ($record['date'] ?? '-')) ?></td>
								<td><span class="att-badge <?= e($statusClass) ?>"><?= e($statusValue) ?></span></td>
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

		<?php if ($pageCount > 1): ?>
			<?php $base = '/attendance?date=' . urlencode($currentDate) . '&q=' . urlencode($currentQuery) . '&status=' . urlencode($currentStatus) . '&page='; ?>
			<nav class="att-pagination">
				<?php for ($i = 1; $i <= $pageCount; $i++): ?>
					<a class="att-page-link <?= $currentPage === $i ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
				<?php endfor; ?>
			</nav>
		<?php endif; ?>
	</section>
</section>
