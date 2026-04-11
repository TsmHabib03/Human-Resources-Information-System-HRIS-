-- HRIS v1 Demo and Initial Super Admin Seed
-- Default super admin credentials:
-- Username: superadmin
-- Email: admin@hris.local
-- Password: Admin@123

INSERT INTO hris_companies (company_name, address, phone, email, website)
SELECT 'Acme HR Solutions', '123 Main Street, Metro City', '+63 900 000 0000', 'hello@acmehr.local', 'https://acmehr.local'
WHERE NOT EXISTS (
    SELECT 1 FROM hris_companies WHERE company_name = 'Acme HR Solutions'
);

SET @company_id = (SELECT MIN(id) FROM hris_companies WHERE company_name = 'Acme HR Solutions');

INSERT INTO hris_branches (company_id, branch_name, address, phone, is_active)
SELECT @company_id, 'Head Office', '123 Main Street, Metro City', '+63 900 000 0001', 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_branches WHERE company_id = @company_id AND branch_name = 'Head Office'
);

SET @branch_id = (SELECT MIN(id) FROM hris_branches WHERE company_id = @company_id AND branch_name = 'Head Office');

INSERT INTO hris_departments (branch_id, department_name, is_active)
SELECT @branch_id, 'Human Resources', 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_departments WHERE branch_id = @branch_id AND department_name = 'Human Resources'
);

INSERT INTO hris_departments (branch_id, department_name, is_active)
SELECT @branch_id, 'Operations', 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_departments WHERE branch_id = @branch_id AND department_name = 'Operations'
);

INSERT INTO hris_departments (branch_id, department_name, is_active)
SELECT @branch_id, 'Finance', 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_departments WHERE branch_id = @branch_id AND department_name = 'Finance'
);

INSERT INTO hris_designations (designation_name, description)
SELECT 'HR Director', 'Leads the HR department'
WHERE NOT EXISTS (
    SELECT 1 FROM hris_designations WHERE designation_name = 'HR Director'
);

INSERT INTO hris_designations (designation_name, description)
SELECT 'HR Officer', 'Handles HR operations'
WHERE NOT EXISTS (
    SELECT 1 FROM hris_designations WHERE designation_name = 'HR Officer'
);

INSERT INTO hris_designations (designation_name, description)
SELECT 'System Administrator', 'Maintains HRIS platform'
WHERE NOT EXISTS (
    SELECT 1 FROM hris_designations WHERE designation_name = 'System Administrator'
);

INSERT INTO hris_leave_types (type_name, description, default_days, is_paid, is_active)
SELECT 'Vacation', 'Annual vacation leave', 10, 1, 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_leave_types WHERE type_name = 'Vacation'
);

INSERT INTO hris_leave_types (type_name, description, default_days, is_paid, is_active)
SELECT 'Sick', 'Sick leave entitlement', 10, 1, 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_leave_types WHERE type_name = 'Sick'
);

INSERT INTO hris_leave_types (type_name, description, default_days, is_paid, is_active)
SELECT 'Emergency', 'Emergency leave', 5, 1, 1
WHERE NOT EXISTS (
    SELECT 1 FROM hris_leave_types WHERE type_name = 'Emergency'
);

SET @hr_dept_id = (SELECT MIN(id) FROM hris_departments WHERE department_name = 'Human Resources');
SET @sysadmin_designation_id = (SELECT MIN(id) FROM hris_designations WHERE designation_name = 'System Administrator');

INSERT INTO hris_employees (
    employee_code, first_name, last_name, gender, date_of_birth,
    department_id, designation_id, employment_type, employment_status, date_hired, email
)
SELECT
    'EMP-0001', 'System', 'Administrator', 'Other', '1990-01-01',
    @hr_dept_id, @sysadmin_designation_id, 'Full-Time', 'Active', CURRENT_DATE, 'admin@hris.local'
WHERE NOT EXISTS (
    SELECT 1 FROM hris_employees WHERE employee_code = 'EMP-0001'
);

SET @admin_employee_id = (SELECT MIN(id) FROM hris_employees WHERE employee_code = 'EMP-0001');
SET @super_admin_role_id = (SELECT MIN(id) FROM hris_roles WHERE role_name = 'Super Admin');

INSERT INTO hris_users (
    username, email, password_hash, role_id, employee_id, is_active, failed_attempts
)
SELECT
    'superadmin',
    'admin@hris.local',
    '$2y$12$VevcIIsG56vvKpem0eRI1ORK.W3EuA/WD29H3qrEyqVgiwU3vFI6e',
    @super_admin_role_id,
    @admin_employee_id,
    1,
    0
WHERE NOT EXISTS (
    SELECT 1 FROM hris_users WHERE username = 'superadmin' OR email = 'admin@hris.local'
);

UPDATE hris_departments
SET head_employee_id = @admin_employee_id
WHERE id = @hr_dept_id;
