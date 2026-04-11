<?php $employee = $employee ?? []; ?>

<section class="stack-md">
	<div class="page-actions">
		<h2>Employee Profile</h2>
		<div class="inline-actions">
			<a href="/employees">Back to list</a>
			<a href="/employees/<?= (int) ($employee['id'] ?? 0) ?>/edit">Edit</a>
		</div>
	</div>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<div class="detail-grid">
		<div><strong>Employee Code:</strong> <?= e((string) ($employee['employee_code'] ?? '-')) ?></div>
		<div><strong>Name:</strong> <?= e((string) (($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? ''))) ?></div>
		<div><strong>Email:</strong> <?= e((string) ($employee['email'] ?? '-')) ?></div>
		<div><strong>Phone:</strong> <?= e((string) ($employee['phone'] ?? '-')) ?></div>
		<div><strong>Gender:</strong> <?= e((string) ($employee['gender'] ?? '-')) ?></div>
		<div><strong>Status:</strong> <?= e((string) ($employee['employment_status'] ?? '-')) ?></div>
		<div><strong>Date Hired:</strong> <?= e((string) ($employee['date_hired'] ?? '-')) ?></div>
		<div><strong>Department ID:</strong> <?= e((string) ($employee['department_id'] ?? '-')) ?></div>
		<div><strong>Designation ID:</strong> <?= e((string) ($employee['designation_id'] ?? '-')) ?></div>
		<div class="full-width"><strong>Address:</strong> <?= e((string) ($employee['address'] ?? '-')) ?></div>
	</div>
</section>
