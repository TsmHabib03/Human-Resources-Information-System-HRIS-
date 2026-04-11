<?php
$model = $employee ?? [];
$input = is_array($old ?? null) && $old !== [] ? $old : $model;
?>

<section class="stack-md">
	<div class="page-actions">
		<h2>Edit Employee</h2>
		<a href="/employees/<?= (int) ($model['id'] ?? 0) ?>">Back to profile</a>
	</div>

	<?php require __DIR__ . '/../partials/alerts.php'; ?>

	<form class="form-grid" method="post" action="/employees/<?= (int) ($model['id'] ?? 0) ?>/update">
		<input type="hidden" name="_csrf" value="<?= e((string) ($csrf ?? '')) ?>">

		<label>First Name<input type="text" name="first_name" value="<?= e((string) ($input['first_name'] ?? '')) ?>" required></label>
		<label>Middle Name<input type="text" name="middle_name" value="<?= e((string) ($input['middle_name'] ?? '')) ?>"></label>
		<label>Last Name<input type="text" name="last_name" value="<?= e((string) ($input['last_name'] ?? '')) ?>" required></label>

		<label>Gender
			<select name="gender" required>
				<?php foreach (['Male', 'Female', 'Other'] as $gender): ?>
					<option value="<?= e($gender) ?>" <?= (($input['gender'] ?? '') === $gender) ? 'selected' : '' ?>><?= e($gender) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Date of Birth<input type="date" name="date_of_birth" value="<?= e((string) ($input['date_of_birth'] ?? '')) ?>" required></label>
		<label>Marital Status
			<select name="marital_status">
				<?php foreach (['Single', 'Married', 'Divorced', 'Widowed'] as $item): ?>
					<option value="<?= e($item) ?>" <?= (($input['marital_status'] ?? 'Single') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Nationality<input type="text" name="nationality" value="<?= e((string) ($input['nationality'] ?? '')) ?>"></label>
		<label>Phone<input type="text" name="phone" value="<?= e((string) ($input['phone'] ?? '')) ?>"></label>
		<label>Email<input type="email" name="email" value="<?= e((string) ($input['email'] ?? '')) ?>"></label>

		<label>Department
			<select name="department_id" required>
				<?php foreach (($departments ?? []) as $department): ?>
					<option value="<?= (int) $department['id'] ?>" <?= ((int) ($input['department_id'] ?? 0) === (int) $department['id']) ? 'selected' : '' ?>>
						<?= e((string) $department['department_name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Designation
			<select name="designation_id" required>
				<?php foreach (($designations ?? []) as $designation): ?>
					<option value="<?= (int) $designation['id'] ?>" <?= ((int) ($input['designation_id'] ?? 0) === (int) $designation['id']) ? 'selected' : '' ?>>
						<?= e((string) $designation['designation_name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Employment Type
			<select name="employment_type">
				<?php foreach (['Full-Time', 'Part-Time', 'Contract', 'Intern'] as $item): ?>
					<option value="<?= e($item) ?>" <?= (($input['employment_type'] ?? 'Full-Time') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label>Employment Status
			<select name="employment_status">
				<?php foreach (['Active', 'Probation', 'On Leave', 'Resigned', 'Terminated'] as $item): ?>
					<option value="<?= e($item) ?>" <?= (($input['employment_status'] ?? 'Active') === $item) ? 'selected' : '' ?>><?= e($item) ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label>Date Hired<input type="date" name="date_hired" value="<?= e((string) ($input['date_hired'] ?? '')) ?>" required></label>
		<label>Date Regularized<input type="date" name="date_regularized" value="<?= e((string) ($input['date_regularized'] ?? '')) ?>"></label>
		<label>Date Separated<input type="date" name="date_separated" value="<?= e((string) ($input['date_separated'] ?? '')) ?>"></label>

		<label>Supervisor
			<select name="supervisor_id">
				<option value="">None</option>
				<?php foreach (($supervisors ?? []) as $supervisor): ?>
					<option value="<?= (int) $supervisor['id'] ?>" <?= ((int) ($input['supervisor_id'] ?? 0) === (int) $supervisor['id']) ? 'selected' : '' ?>>
						<?= e((string) ($supervisor['employee_code'] . ' - ' . $supervisor['first_name'] . ' ' . $supervisor['last_name'])) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<label class="full-width">Address<textarea name="address" rows="3"><?= e((string) ($input['address'] ?? '')) ?></textarea></label>

		<div class="full-width">
			<button class="btn btn-primary" type="submit">Update Employee</button>
		</div>
	</form>
</section>
