<?php
$leaveRequests = is_array($requests ?? null) ? $requests : [];
$employeeOptions = is_array($employees ?? null) ? $employees : [];
$typeOptions = is_array($leaveTypes ?? null) ? $leaveTypes : [];
$statusList = is_array($statusOptions ?? null) ? $statusOptions : [];
$oldInput = is_array($old ?? null) ? $old : [];
$currentEmployeeRecord = is_array($currentEmployee ?? null) ? $currentEmployee : [];
$isSelfServiceUser = (bool) ($isSelfService ?? false);
$canRequestLeave = can('leave.request');
$canApproveLeave = can('leave.approve');

$currentQuery = (string) ($query ?? '');
$currentStatus = (string) ($status ?? '');
$currentPage = (int) ($page ?? 1);
$pageCount = (int) ($totalPages ?? 1);
$totalCount = (int) ($total ?? 0);
$selectedEmployeeId = $isSelfServiceUser
	? (int) ($currentEmployeeRecord['id'] ?? 0)
	: (int) ($oldInput['employee_id'] ?? 0);

$pendingCount = 0;
$approvedCount = 0;
$rejectedCount = 0;

foreach ($leaveRequests as $entry) {
	$entryStatus = (string) ($entry['status'] ?? '');
	if ($entryStatus === 'Pending') {
		$pendingCount++;
	} elseif ($entryStatus === 'Approved') {
		$approvedCount++;
	} elseif ($entryStatus === 'Rejected') {
		$rejectedCount++;
	}
}

$statusClassMap = [
	'pending' => 'leave-badge-pending',
	'approved' => 'leave-badge-approved',
	'rejected' => 'leave-badge-rejected',
	'cancelled' => 'leave-badge-cancelled',
];
?>

<section class="leave-page">
	<header class="leave-hero">
		<div class="leave-hero-copy">
			<p class="leave-kicker">Leave Management</p>
			<h2 class="leave-title font-display">Manage requests and approvals in one workflow</h2>
			<p class="leave-subtitle">Submit leave requests, review status quickly, and process approvals without context switching.</p>
			<div class="leave-tags">
				<span class="leave-tag">Request intake</span>
				<span class="leave-tag">Approval queue</span>
				<span class="leave-tag">Audit tracked</span>
			</div>
		</div>

		<aside class="leave-hero-side">
			<article class="leave-stat">
				<span class="leave-stat-label">Total requests</span>
				<span class="leave-stat-value"><?= e((string) $totalCount) ?></span>
			</article>
			<article class="leave-stat">
				<span class="leave-stat-label">Pending</span>
				<span class="leave-stat-value"><?= e((string) $pendingCount) ?></span>
			</article>
			<article class="leave-stat">
				<span class="leave-stat-label">Approved / Rejected</span>
				<span class="leave-stat-value"><?= e((string) ($approvedCount + $rejectedCount)) ?></span>
			</article>
		</aside>
	</header>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<?php if ($canRequestLeave): ?>
		<section class="leave-card">
			<div class="leave-section-head">
				<h3>Submit Leave Request</h3>
				<p>Create a leave request by selecting employee, type, and date range.</p>
			</div>

			<form class="leave-form-grid" method="post" action="/leave/request">
				<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

				<?php if ($isSelfServiceUser): ?>
					<?php if ($selectedEmployeeId > 0): ?>
						<input type="hidden" name="employee_id" value="<?= $selectedEmployeeId ?>">
						<div class="leave-field full">
							<label>Employee</label>
							<p class="leave-form-hint">
								<?= e((string) (($currentEmployeeRecord['employee_code'] ?? '-') . ' - ' . ($currentEmployeeRecord['first_name'] ?? '') . ' ' . ($currentEmployeeRecord['last_name'] ?? ''))) ?>
							</p>
						</div>
					<?php else: ?>
						<div class="leave-field full">
							<label>Employee</label>
							<p class="leave-form-hint">Your account is not linked to an employee profile.</p>
						</div>
					<?php endif; ?>
				<?php else: ?>
					<div class="leave-field">
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
				<?php endif; ?>

				<div class="leave-field">
					<label for="leave_type_id">Leave Type</label>
					<select id="leave_type_id" name="leave_type_id" required>
						<option value="">Select</option>
						<?php foreach ($typeOptions as $leaveType): ?>
							<option value="<?= (int) $leaveType['id'] ?>" <?= ((int) ($oldInput['leave_type_id'] ?? 0) === (int) $leaveType['id']) ? 'selected' : '' ?>>
								<?= e((string) $leaveType['type_name']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="leave-field">
					<label for="start_date">Start Date</label>
					<input id="start_date" type="date" name="start_date" value="<?= e((string) ($oldInput['start_date'] ?? '')) ?>" required>
				</div>

				<div class="leave-field">
					<label for="end_date">End Date</label>
					<input id="end_date" type="date" name="end_date" value="<?= e((string) ($oldInput['end_date'] ?? '')) ?>" required>
				</div>

				<div class="leave-field">
					<label for="total_days">Total Days</label>
					<input id="total_days" type="number" step="0.5" name="total_days" value="<?= e((string) ($oldInput['total_days'] ?? '')) ?>" required>
				</div>

				<div class="leave-field full">
					<label for="reason">Reason</label>
					<textarea id="reason" name="reason" rows="2"><?= e((string) ($oldInput['reason'] ?? '')) ?></textarea>
				</div>

				<?php if (!$isSelfServiceUser || $selectedEmployeeId > 0): ?>
					<div class="leave-field full leave-form-actions">
						<p class="leave-form-hint">Overlapping pending/approved requests are blocked automatically.</p>
						<button class="leave-btn-primary" type="submit">Submit request</button>
					</div>
				<?php endif; ?>
			</form>
		</section>
	<?php endif; ?>

	<section class="leave-card leave-toolbar">
		<div class="leave-section-head">
			<h3>Request Queue</h3>
			<p><?= $canApproveLeave ? 'Filter by employee or leave status, then approve or reject pending items.' : 'Filter by leave status and review request progress.' ?></p>
		</div>

		<form class="leave-filter-form" method="get" action="/leave">
			<label class="leave-filter-field">
				<span>Search</span>
				<input type="text" name="q" value="<?= e($currentQuery) ?>" placeholder="Employee code, name, or leave type">
			</label>

			<label class="leave-filter-field">
				<span>Status</span>
				<select name="status">
					<option value="">All statuses</option>
					<?php foreach ($statusList as $item): ?>
						<option value="<?= e((string) $item) ?>" <?= ($currentStatus === $item) ? 'selected' : '' ?>><?= e((string) $item) ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<button class="leave-filter-btn" type="submit">Apply filters</button>
		</form>

		<div class="leave-table-wrap">
			<table class="leave-table">
				<thead>
					<tr>
						<th>Employee</th>
						<th>Type</th>
						<th>Dates</th>
						<th>Days</th>
						<th>Status</th>
						<th>Reason</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($leaveRequests === []): ?>
						<tr>
							<td colspan="7">
								<p class="leave-empty">No leave requests found for the current filters.</p>
							</td>
						</tr>
					<?php else: ?>
						<?php foreach ($leaveRequests as $request): ?>
							<?php
							$statusValue = (string) ($request['status'] ?? 'Unknown');
							$statusKey = strtolower(str_replace([' ', '-'], '_', $statusValue));
							$statusClass = $statusClassMap[$statusKey] ?? 'leave-badge-default';
							?>
							<tr>
								<td>
									<div class="leave-name">
										<strong><?= e((string) (($request['first_name'] ?? '') . ' ' . ($request['last_name'] ?? ''))) ?></strong>
										<span><?= e((string) ($request['employee_code'] ?? '-')) ?></span>
									</div>
								</td>
								<td><?= e((string) ($request['type_name'] ?? '-')) ?></td>
								<td><?= e((string) (($request['start_date'] ?? '-') . ' to ' . ($request['end_date'] ?? '-'))) ?></td>
								<td><?= e((string) ($request['total_days'] ?? '-')) ?></td>
								<td><span class="leave-badge <?= e($statusClass) ?>"><?= e($statusValue) ?></span></td>
								<td><?= e((string) ($request['reason'] ?? '-')) ?></td>
								<td>
									<div class="leave-actions">
										<?php if ($statusValue === 'Pending'): ?>
											<?php if ($canApproveLeave): ?>
												<form method="post" action="/leave/<?= (int) ($request['id'] ?? 0) ?>/approve">
													<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
													<input type="hidden" name="review_remarks" value="Approved">
													<button class="leave-action-btn approve" type="submit">Approve</button>
												</form>
												<form method="post" action="/leave/<?= (int) ($request['id'] ?? 0) ?>/reject">
													<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
													<input type="hidden" name="review_remarks" value="Rejected">
													<button class="leave-action-btn reject" type="submit">Reject</button>
												</form>
											<?php else: ?>
												<span>-</span>
											<?php endif; ?>
										<?php else: ?>
											<span>-</span>
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
			<?php $base = '/leave?q=' . urlencode($currentQuery) . '&status=' . urlencode($currentStatus) . '&page='; ?>
			<nav class="leave-pagination">
				<?php for ($i = 1; $i <= $pageCount; $i++): ?>
					<a class="leave-page-link <?= $currentPage === $i ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
				<?php endfor; ?>
			</nav>
		<?php endif; ?>
	</section>
</section>
