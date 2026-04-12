<?php
$employee = is_array($employee ?? null) ? $employee : [];
$name = trim((string) (($employee['first_name'] ?? '') . ' ' . ($employee['last_name'] ?? '')));
$status = (string) ($employee['employment_status'] ?? 'Unknown');
$statusKey = strtolower(str_replace([' ', '-'], '_', $status));
$statusClassMap = [
	'active' => 'emp-badge-active',
	'probation' => 'emp-badge-probation',
	'on_leave' => 'emp-badge-on_leave',
	'resigned' => 'emp-badge-resigned',
	'terminated' => 'emp-badge-terminated',
];
$statusClass = $statusClassMap[$statusKey] ?? 'emp-badge-default';
?>

<section class="emp-page">
	<header class="emp-hero">
		<div class="emp-hero-copy">
			<p class="emp-kicker">Employee Profile</p>
			<h2 class="emp-title font-display"><?= e($name !== '' ? $name : 'Unknown employee') ?></h2>
			<p class="emp-subtitle">Employee code: <?= e((string) ($employee['employee_code'] ?? '-')) ?></p>
			<div class="emp-tags">
				<span class="emp-badge <?= e($statusClass) ?>"><?= e($status) ?></span>
			</div>
		</div>

		<div class="emp-hero-actions">
			<a class="emp-action-link" href="/employees">Back to list</a>
			<a class="emp-action-primary" href="/employees/<?= (int) ($employee['id'] ?? 0) ?>/edit">Edit profile</a>
		</div>
	</header>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<section class="emp-profile-grid">
		<article class="emp-profile-card">
			<h3>Identity</h3>
			<dl class="emp-detail-list">
				<div>
					<dt>First Name</dt>
					<dd><?= e((string) ($employee['first_name'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Middle Name</dt>
					<dd><?= e((string) ($employee['middle_name'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Last Name</dt>
					<dd><?= e((string) ($employee['last_name'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Gender</dt>
					<dd><?= e((string) ($employee['gender'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Date of Birth</dt>
					<dd><?= e((string) ($employee['date_of_birth'] ?? '-')) ?></dd>
				</div>
			</dl>
		</article>

		<article class="emp-profile-card">
			<h3>Employment</h3>
			<dl class="emp-detail-list">
				<div>
					<dt>Status</dt>
					<dd><?= e($status) ?></dd>
				</div>
				<div>
					<dt>Employment Type</dt>
					<dd><?= e((string) ($employee['employment_type'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Date Hired</dt>
					<dd><?= e((string) ($employee['date_hired'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Date Regularized</dt>
					<dd><?= e((string) ($employee['date_regularized'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Date Separated</dt>
					<dd><?= e((string) ($employee['date_separated'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Supervisor ID</dt>
					<dd><?= e((string) ($employee['supervisor_id'] ?? '-')) ?></dd>
				</div>
			</dl>
		</article>

		<article class="emp-profile-card">
			<h3>Contact</h3>
			<dl class="emp-detail-list">
				<div>
					<dt>Email</dt>
					<dd><?= e((string) ($employee['email'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Phone</dt>
					<dd><?= e((string) ($employee['phone'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Nationality</dt>
					<dd><?= e((string) ($employee['nationality'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Marital Status</dt>
					<dd><?= e((string) ($employee['marital_status'] ?? '-')) ?></dd>
				</div>
			</dl>
		</article>

		<article class="emp-profile-card">
			<h3>Organization</h3>
			<dl class="emp-detail-list">
				<div>
					<dt>Department ID</dt>
					<dd><?= e((string) ($employee['department_id'] ?? '-')) ?></dd>
				</div>
				<div>
					<dt>Designation ID</dt>
					<dd><?= e((string) ($employee['designation_id'] ?? '-')) ?></dd>
				</div>
			</dl>
		</article>

		<article class="emp-profile-card full">
			<h3>Address</h3>
			<dl class="emp-detail-list">
				<div>
					<dt>Current Address</dt>
					<dd><?= e((string) ($employee['address'] ?? '-')) ?></dd>
				</div>
			</dl>
		</article>
	</section>
</section>
