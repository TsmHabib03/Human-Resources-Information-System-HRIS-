<section class="stack-md">
	<h2>Leave Management</h2>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<form class="form-grid" method="post" action="/leave/request">
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

		<label>Leave Type
			<select name="leave_type_id" required>
				<option value="">Select</option>
				<?php foreach (($leaveTypes ?? []) as $leaveType): ?>
					<option value="<?= (int) $leaveType['id'] ?>" <?= ((int) (($old['leave_type_id'] ?? 0)) === (int) $leaveType['id']) ? 'selected' : '' ?>><?= e((string) $leaveType['type_name']) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Start Date<input type="date" name="start_date" value="<?= e((string) ($old['start_date'] ?? '')) ?>" required></label>
		<label>End Date<input type="date" name="end_date" value="<?= e((string) ($old['end_date'] ?? '')) ?>" required></label>
		<label>Total Days<input type="number" step="0.5" name="total_days" value="<?= e((string) ($old['total_days'] ?? '')) ?>" required></label>
		<label class="full-width">Reason<textarea name="reason" rows="2"><?= e((string) ($old['reason'] ?? '')) ?></textarea></label>

		<div class="full-width">
			<button class="btn btn-primary" type="submit">Submit Leave Request</button>
		</div>
	</form>

	<form class="inline-actions" method="get" action="/leave">
		<input type="text" name="q" value="<?= e((string) ($query ?? '')) ?>" placeholder="Search employee or leave type">
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
					<th>Type</th>
					<th>Dates</th>
					<th>Days</th>
					<th>Status</th>
					<th>Reason</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (empty($requests)): ?>
					<tr><td colspan="7">No leave requests found.</td></tr>
				<?php else: ?>
					<?php foreach ($requests as $request): ?>
						<tr>
							<td><?= e((string) ($request['employee_code'] . ' - ' . $request['first_name'] . ' ' . $request['last_name'])) ?></td>
							<td><?= e((string) $request['type_name']) ?></td>
							<td><?= e((string) ($request['start_date'] . ' to ' . $request['end_date'])) ?></td>
							<td><?= e((string) $request['total_days']) ?></td>
							<td><span class="badge"><?= e((string) $request['status']) ?></span></td>
							<td><?= e((string) ($request['reason'] ?? '-')) ?></td>
							<td class="actions-cell">
								<?php if (($request['status'] ?? '') === 'Pending'): ?>
									<form method="post" action="/leave/<?= (int) $request['id'] ?>/approve">
										<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
										<input type="hidden" name="review_remarks" value="Approved">
										<button class="btn-link" type="submit">Approve</button>
									</form>
									<form method="post" action="/leave/<?= (int) $request['id'] ?>/reject">
										<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">
										<input type="hidden" name="review_remarks" value="Rejected">
										<button class="btn-link danger" type="submit">Reject</button>
									</form>
								<?php else: ?>
									<span>-</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<?php if (($totalPages ?? 1) > 1): ?>
		<?php $base = '/leave?q=' . urlencode((string) ($query ?? '')) . '&status=' . urlencode((string) ($status ?? '')) . '&page='; ?>
		<nav class="pagination">
			<?php for ($i = 1; $i <= (int) $totalPages; $i++): ?>
				<a class="page-link <?= ((int) ($page ?? 1) === $i) ? 'is-active' : '' ?>" href="<?= e($base . $i) ?>"><?= $i ?></a>
			<?php endfor; ?>
		</nav>
	<?php endif; ?>
</section>
