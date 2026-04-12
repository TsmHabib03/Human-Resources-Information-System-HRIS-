<?php
$oldInput = is_array($old ?? null) ? $old : [];
$departmentOptions = is_array($departments ?? null) ? $departments : [];
$designationOptions = is_array($designations ?? null) ? $designations : [];
$supervisorOptions = is_array($supervisors ?? null) ? $supervisors : [];
?>

<section class="emp-page">
	<header class="emp-hero">
		<div class="emp-hero-copy">
			<p class="emp-kicker">Create Employee</p>
			<h2 class="emp-title font-display">Add a new team member profile</h2>
			<p class="emp-subtitle">Capture identity, assignment, and employment details in one structured flow.</p>
			<div class="emp-tags">
				<span class="emp-tag">Guided data entry</span>
				<span class="emp-tag">Validation ready</span>
			</div>
		</div>

		<div class="emp-hero-actions">
			<a class="emp-action-link" href="/employees">Back to list</a>
		</div>
	</header>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<form class="emp-form-card" method="post" action="/employees">
		<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

		<section class="emp-form-section">
			<div class="emp-section-head">
				<h3>Personal Details</h3>
				<p>Basic information used across attendance, payroll, and leave workflows.</p>
			</div>

			<div class="emp-form-grid">
				<div class="emp-field">
					<label for="first_name">First Name</label>
					<input id="first_name" type="text" name="first_name" value="<?= e((string) ($oldInput['first_name'] ?? '')) ?>" required>
				</div>

				<div class="emp-field">
					<label for="middle_name">Middle Name</label>
					<input id="middle_name" type="text" name="middle_name" value="<?= e((string) ($oldInput['middle_name'] ?? '')) ?>">
				</div>

				<div class="emp-field">
					<label for="last_name">Last Name</label>
					<input id="last_name" type="text" name="last_name" value="<?= e((string) ($oldInput['last_name'] ?? '')) ?>" required>
				</div>

				<div class="emp-field">
					<label for="gender">Gender</label>
					<select id="gender" name="gender" required>
						<option value="">Select</option>
						<?php foreach (['Male', 'Female', 'Other'] as $gender): ?>
							<option value="<?= e($gender) ?>" <?= (($oldInput['gender'] ?? '') === $gender) ? 'selected' : '' ?>><?= e($gender) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="emp-field">
					<label for="date_of_birth">Date of Birth</label>
					<input id="date_of_birth" type="date" name="date_of_birth" value="<?= e((string) ($oldInput['date_of_birth'] ?? '')) ?>" required>
				</div>

				<div class="emp-field">
					<label for="marital_status">Marital Status</label>
					<select id="marital_status" name="marital_status">
						<?php foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $item): ?>
							<option value="<?= e($item) ?>" <?= (($oldInput['marital_status'] ?? 'Single') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="emp-field">
					<label for="nationality">Nationality</label>
					<input id="nationality" type="text" name="nationality" value="<?= e((string) ($oldInput['nationality'] ?? '')) ?>">
				</div>

				<div class="emp-field">
					<label for="phone">Phone</label>
					<input id="phone" type="text" name="phone" value="<?= e((string) ($oldInput['phone'] ?? '')) ?>">
				</div>

				<div class="emp-field">
					<label for="email">Email</label>
					<input id="email" type="email" name="email" value="<?= e((string) ($oldInput['email'] ?? '')) ?>">
				</div>

				<div class="emp-field full">
					<label for="address">Address</label>
					<textarea id="address" name="address" rows="3"><?= e((string) ($oldInput['address'] ?? '')) ?></textarea>
				</div>
			</div>
		</section>

		<section class="emp-form-section">
			<div class="emp-section-head">
				<h3>Employment Details</h3>
				<p>Assignment and status details that control downstream module visibility.</p>
			</div>

			<div class="emp-form-grid">
				<div class="emp-field">
					<label for="department_id">Department</label>
					<select id="department_id" name="department_id" required>
						<option value="">Select</option>
						<?php foreach ($departmentOptions as $department): ?>
							<option value="<?= (int) $department['id'] ?>" <?= ((string) ($oldInput['department_id'] ?? '') === (string) $department['id']) ? 'selected' : '' ?>>
								<?= e((string) $department['department_name']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="emp-field">
					<label for="designation_id">Designation</label>
					<select id="designation_id" name="designation_id" required>
						<option value="">Select</option>
						<?php foreach ($designationOptions as $designation): ?>
							<option value="<?= (int) $designation['id'] ?>" <?= ((string) ($oldInput['designation_id'] ?? '') === (string) $designation['id']) ? 'selected' : '' ?>>
								<?= e((string) $designation['designation_name']) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="emp-field">
					<label for="employment_type">Employment Type</label>
					<select id="employment_type" name="employment_type">
						<?php foreach (['Full-Time', 'Part-Time', 'Contract', 'Intern'] as $item): ?>
							<option value="<?= e($item) ?>" <?= (($oldInput['employment_type'] ?? 'Full-Time') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="emp-field">
					<label for="employment_status">Employment Status</label>
					<select id="employment_status" name="employment_status">
						<?php foreach (['Active', 'Probation', 'On Leave', 'Resigned', 'Terminated'] as $item): ?>
							<option value="<?= e($item) ?>" <?= (($oldInput['employment_status'] ?? 'Active') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="emp-field">
					<label for="date_hired">Date Hired</label>
					<input id="date_hired" type="date" name="date_hired" value="<?= e((string) ($oldInput['date_hired'] ?? '')) ?>" required>
				</div>

				<div class="emp-field">
					<label for="date_regularized">Date Regularized</label>
					<input id="date_regularized" type="date" name="date_regularized" value="<?= e((string) ($oldInput['date_regularized'] ?? '')) ?>">
				</div>

				<div class="emp-field">
					<label for="date_separated">Date Separated</label>
					<input id="date_separated" type="date" name="date_separated" value="<?= e((string) ($oldInput['date_separated'] ?? '')) ?>">
				</div>

				<div class="emp-field full">
					<label for="supervisor_id">Supervisor</label>
					<select id="supervisor_id" name="supervisor_id">
						<option value="">None</option>
						<?php foreach ($supervisorOptions as $supervisor): ?>
							<option value="<?= (int) $supervisor['id'] ?>" <?= ((string) ($oldInput['supervisor_id'] ?? '') === (string) $supervisor['id']) ? 'selected' : '' ?>>
								<?= e((string) ($supervisor['employee_code'] . ' - ' . $supervisor['first_name'] . ' ' . $supervisor['last_name'])) ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</section>

		<div class="emp-form-actions">
			<p class="emp-form-hint">Required fields are validated before employee creation.</p>
			<div class="emp-hero-actions">
				<a class="emp-action-link" href="/employees">Cancel</a>
				<button class="emp-action-primary" type="submit">Create employee</button>
			</div>
		</div>
	</form>
</section>
