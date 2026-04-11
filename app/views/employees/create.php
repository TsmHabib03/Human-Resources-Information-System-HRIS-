<section class="stack-md">
	<div class="page-actions">
		<h2>Create Employee</h2>
		<a href="/employees">Back to list</a>
	</div>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<form class="form-grid" method="post" action="/employees">
		<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

		<label>First Name<input type="text" name="first_name" value="<?= e((string) (($old['first_name'] ?? ''))) ?>" required></label>
		<label>Middle Name<input type="text" name="middle_name" value="<?= e((string) (($old['middle_name'] ?? ''))) ?>"></label>
		<label>Last Name<input type="text" name="last_name" value="<?= e((string) (($old['last_name'] ?? ''))) ?>" required></label>

		<label>Gender
			<select name="gender" required>
				<option value="">Select</option>
				<option value="Male">Male</option>
				<option value="Female">Female</option>
				<option value="Other">Other</option>
			</select>
		</label>

		<label>Date of Birth<input type="date" name="date_of_birth" value="<?= e((string) (($old['date_of_birth'] ?? ''))) ?>" required></label>
		<label>Marital Status
			<select name="marital_status">
				<?php foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $item): ?>
					<option value="<?= e($item) ?>" <?= (($old['marital_status'] ?? 'Single') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Nationality<input type="text" name="nationality" value="<?= e((string) (($old['nationality'] ?? ''))) ?>"></label>
		<label>Phone<input type="text" name="phone" value="<?= e((string) (($old['phone'] ?? ''))) ?>"></label>
		<label>Email<input type="email" name="email" value="<?= e((string) (($old['email'] ?? ''))) ?>"></label>

		<label>Department
			<select name="department_id" required>
				<option value="">Select</option>
				<?php foreach (($departments ?? []) as $department): ?>
					<option value="<?= (int) $department['id'] ?>"><?= e((string) $department['department_name']) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Designation
			<select name="designation_id" required>
				<option value="">Select</option>
				<?php foreach (($designations ?? []) as $designation): ?>
					<option value="<?= (int) $designation['id'] ?>"><?= e((string) $designation['designation_name']) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Employment Type
			<select name="employment_type">
				<?php foreach (['Full-Time', 'Part-Time', 'Contract', 'Intern'] as $item): ?>
					<option value="<?= e($item) ?>" <?= (($old['employment_type'] ?? 'Full-Time') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Employment Status
			<select name="employment_status">
				<?php foreach (['Active', 'Probation', 'On Leave', 'Resigned', 'Terminated'] as $item): ?>
					<option value="<?= e($item) ?>" <?= (($old['employment_status'] ?? 'Active') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Date Hired<input type="date" name="date_hired" value="<?= e((string) (($old['date_hired'] ?? ''))) ?>" required></label>
		<label>Date Regularized<input type="date" name="date_regularized" value="<?= e((string) (($old['date_regularized'] ?? ''))) ?>"></label>
		<label>Date Separated<input type="date" name="date_separated" value="<?= e((string) (($old['date_separated'] ?? ''))) ?>"></label>

		<label>Supervisor
			<select name="supervisor_id">
				<option value="">None</option>
				<?php foreach (($supervisors ?? []) as $supervisor): ?>
					<option value="<?= (int) $supervisor['id'] ?>"><?= e((string) ($supervisor['employee_code'] . ' - ' . $supervisor['first_name'] . ' ' . $supervisor['last_name'])) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label class="full-width">Address<textarea name="address" rows="3"><?= e((string) (($old['address'] ?? ''))) ?></textarea></label>

		<div class="full-width">
			<button class="btn btn-primary" type="submit">Create Employee</button>
		</div>
	</form>
</section>
