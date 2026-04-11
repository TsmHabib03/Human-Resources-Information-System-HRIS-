-- HRIS v1 Initial Schema
-- Target DB: hris_db
-- Engine: InnoDB
-- Charset/Collation: utf8mb4 / utf8mb4_unicode_ci

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS hris_audit_log;
DROP TABLE IF EXISTS hris_announcements;
DROP TABLE IF EXISTS hris_deductions;
DROP TABLE IF EXISTS hris_allowances;
DROP TABLE IF EXISTS hris_employee_salaries;
DROP TABLE IF EXISTS hris_salary_grades;
DROP TABLE IF EXISTS hris_leave_requests;
DROP TABLE IF EXISTS hris_leave_balances;
DROP TABLE IF EXISTS hris_leave_types;
DROP TABLE IF EXISTS hris_timesheets;
DROP TABLE IF EXISTS hris_attendance;
DROP TABLE IF EXISTS hris_employee_documents;
DROP TABLE IF EXISTS hris_employee_contacts;
DROP TABLE IF EXISTS hris_users;
DROP TABLE IF EXISTS hris_role_permissions;
DROP TABLE IF EXISTS hris_permissions;
DROP TABLE IF EXISTS hris_roles;
DROP TABLE IF EXISTS hris_employees;
DROP TABLE IF EXISTS hris_departments;
DROP TABLE IF EXISTS hris_designations;
DROP TABLE IF EXISTS hris_branches;
DROP TABLE IF EXISTS hris_companies;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE hris_roles (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_name   VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_permissions (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    permission_key  VARCHAR(100) NOT NULL UNIQUE,
    module          VARCHAR(50) NOT NULL,
    description     VARCHAR(255) DEFAULT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_role_permissions (
    role_id       INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES hris_roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES hris_permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_companies (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(150) NOT NULL,
    address      TEXT,
    phone        VARCHAR(30) DEFAULT NULL,
    email        VARCHAR(150) DEFAULT NULL,
    website      VARCHAR(255) DEFAULT NULL,
    logo_path    VARCHAR(255) DEFAULT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_branches (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    company_id  INT UNSIGNED NOT NULL,
    branch_name VARCHAR(100) NOT NULL,
    address     TEXT,
    phone       VARCHAR(30) DEFAULT NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES hris_companies(id) ON DELETE CASCADE,
    INDEX idx_branch_company (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_departments (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    branch_id        INT UNSIGNED NOT NULL,
    department_name  VARCHAR(100) NOT NULL,
    head_employee_id INT UNSIGNED DEFAULT NULL,
    is_active        TINYINT(1) NOT NULL DEFAULT 1,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (branch_id) REFERENCES hris_branches(id) ON DELETE CASCADE,
    INDEX idx_dept_branch (branch_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_designations (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    designation_name VARCHAR(100) NOT NULL,
    description      VARCHAR(255) DEFAULT NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_employees (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_code     VARCHAR(20) NOT NULL UNIQUE,
    first_name        VARCHAR(80) NOT NULL,
    middle_name       VARCHAR(80) DEFAULT NULL,
    last_name         VARCHAR(80) NOT NULL,
    gender            ENUM('Male','Female','Other') NOT NULL,
    date_of_birth     DATE NOT NULL,
    marital_status    ENUM('Single','Married','Divorced','Widowed') DEFAULT 'Single',
    nationality       VARCHAR(60) DEFAULT NULL,
    phone             VARCHAR(30) DEFAULT NULL,
    email             VARCHAR(150) DEFAULT NULL,
    address           TEXT,
    photo_path        VARCHAR(255) DEFAULT NULL,
    department_id     INT UNSIGNED NOT NULL,
    designation_id    INT UNSIGNED NOT NULL,
    employment_type   ENUM('Full-Time','Part-Time','Contract','Intern') DEFAULT 'Full-Time',
    employment_status ENUM('Active','Probation','On Leave','Resigned','Terminated') DEFAULT 'Active',
    date_hired        DATE NOT NULL,
    date_regularized  DATE DEFAULT NULL,
    date_separated    DATE DEFAULT NULL,
    supervisor_id     INT UNSIGNED DEFAULT NULL,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES hris_departments(id) ON DELETE RESTRICT,
    FOREIGN KEY (designation_id) REFERENCES hris_designations(id) ON DELETE RESTRICT,
    FOREIGN KEY (supervisor_id) REFERENCES hris_employees(id) ON DELETE SET NULL,
    INDEX idx_emp_dept (department_id),
    INDEX idx_emp_status (employment_status),
    INDEX idx_emp_supervisor (supervisor_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_users (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(50) NOT NULL UNIQUE,
    email           VARCHAR(150) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    role_id         INT UNSIGNED NOT NULL,
    employee_id     INT UNSIGNED DEFAULT NULL,
    is_active       TINYINT(1) NOT NULL DEFAULT 1,
    last_login      DATETIME DEFAULT NULL,
    failed_attempts TINYINT UNSIGNED DEFAULT 0,
    locked_until    DATETIME DEFAULT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES hris_roles(id) ON DELETE RESTRICT,
    INDEX idx_users_email (email),
    INDEX idx_users_employee (employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_user_sessions (
    id            VARCHAR(128) PRIMARY KEY,
    user_id       INT UNSIGNED NOT NULL,
    ip_address    VARCHAR(45) NOT NULL,
    user_agent    VARCHAR(255) DEFAULT NULL,
    payload       TEXT,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES hris_users(id) ON DELETE CASCADE,
    INDEX idx_sessions_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_employee_contacts (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id  INT UNSIGNED NOT NULL,
    contact_name VARCHAR(100) NOT NULL,
    relationship VARCHAR(50) NOT NULL,
    phone        VARCHAR(30) NOT NULL,
    address      TEXT DEFAULT NULL,
    is_primary   TINYINT(1) DEFAULT 0,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_employee_documents (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id   INT UNSIGNED NOT NULL,
    document_type VARCHAR(50) NOT NULL,
    document_name VARCHAR(150) NOT NULL,
    file_path     VARCHAR(255) NOT NULL,
    expiry_date   DATE DEFAULT NULL,
    uploaded_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_attendance (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id  INT UNSIGNED NOT NULL,
    date         DATE NOT NULL,
    clock_in     DATETIME DEFAULT NULL,
    clock_out    DATETIME DEFAULT NULL,
    hours_worked DECIMAL(5,2) DEFAULT NULL,
    overtime_hrs DECIMAL(5,2) DEFAULT 0,
    status       ENUM('Present','Absent','Late','Half-Day','Holiday','Rest Day') DEFAULT 'Present',
    remarks      VARCHAR(255) DEFAULT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE,
    UNIQUE KEY uq_attendance (employee_id, date),
    INDEX idx_att_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_timesheets (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id  INT UNSIGNED NOT NULL,
    period_start DATE NOT NULL,
    period_end   DATE NOT NULL,
    total_hours  DECIMAL(6,2) DEFAULT 0,
    total_ot     DECIMAL(6,2) DEFAULT 0,
    status       ENUM('Draft','Submitted','Approved','Rejected') DEFAULT 'Draft',
    approved_by  INT UNSIGNED DEFAULT NULL,
    approved_at  DATETIME DEFAULT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES hris_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_leave_types (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type_name    VARCHAR(60) NOT NULL UNIQUE,
    description  VARCHAR(255) DEFAULT NULL,
    default_days DECIMAL(4,1) NOT NULL DEFAULT 0,
    is_paid      TINYINT(1) DEFAULT 1,
    is_active    TINYINT(1) DEFAULT 1,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_leave_balances (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id    INT UNSIGNED NOT NULL,
    leave_type_id  INT UNSIGNED NOT NULL,
    year           YEAR NOT NULL,
    total_days     DECIMAL(4,1) NOT NULL DEFAULT 0,
    used_days      DECIMAL(4,1) NOT NULL DEFAULT 0,
    remaining_days DECIMAL(4,1) GENERATED ALWAYS AS (total_days - used_days) STORED,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE,
    FOREIGN KEY (leave_type_id) REFERENCES hris_leave_types(id) ON DELETE CASCADE,
    UNIQUE KEY uq_leave_bal (employee_id, leave_type_id, year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_leave_requests (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id    INT UNSIGNED NOT NULL,
    leave_type_id  INT UNSIGNED NOT NULL,
    start_date     DATE NOT NULL,
    end_date       DATE NOT NULL,
    total_days     DECIMAL(4,1) NOT NULL,
    reason         TEXT DEFAULT NULL,
    status         ENUM('Pending','Approved','Rejected','Cancelled') DEFAULT 'Pending',
    reviewed_by    INT UNSIGNED DEFAULT NULL,
    reviewed_at    DATETIME DEFAULT NULL,
    review_remarks VARCHAR(255) DEFAULT NULL,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE,
    FOREIGN KEY (leave_type_id) REFERENCES hris_leave_types(id) ON DELETE RESTRICT,
    FOREIGN KEY (reviewed_by) REFERENCES hris_users(id) ON DELETE SET NULL,
    INDEX idx_leave_emp (employee_id),
    INDEX idx_leave_status (status),
    INDEX idx_leave_dates (start_date, end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_salary_grades (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    grade_name VARCHAR(50) NOT NULL UNIQUE,
    min_salary DECIMAL(12,2) NOT NULL,
    max_salary DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_employee_salaries (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id     INT UNSIGNED NOT NULL,
    salary_grade_id INT UNSIGNED DEFAULT NULL,
    basic_salary    DECIMAL(12,2) NOT NULL,
    effective_date  DATE NOT NULL,
    is_current      TINYINT(1) DEFAULT 1,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE CASCADE,
    FOREIGN KEY (salary_grade_id) REFERENCES hris_salary_grades(id) ON DELETE SET NULL,
    INDEX idx_sal_emp (employee_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_allowances (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    allowance_name VARCHAR(80) NOT NULL,
    description    VARCHAR(255) DEFAULT NULL,
    is_taxable     TINYINT(1) DEFAULT 0,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_deductions (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    deduction_name VARCHAR(80) NOT NULL,
    description    VARCHAR(255) DEFAULT NULL,
    is_mandatory   TINYINT(1) DEFAULT 0,
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_announcements (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title      VARCHAR(200) NOT NULL,
    content    TEXT NOT NULL,
    priority   ENUM('Low','Normal','High','Critical') DEFAULT 'Normal',
    posted_by  INT UNSIGNED NOT NULL,
    is_active  TINYINT(1) DEFAULT 1,
    starts_at  DATE DEFAULT NULL,
    expires_at DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (posted_by) REFERENCES hris_users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hris_audit_log (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    INT UNSIGNED DEFAULT NULL,
    action     VARCHAR(50) NOT NULL,
    module     VARCHAR(50) NOT NULL,
    record_id  INT UNSIGNED DEFAULT NULL,
    old_values JSON DEFAULT NULL,
    new_values JSON DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES hris_users(id) ON DELETE SET NULL,
    INDEX idx_audit_user (user_id),
    INDEX idx_audit_module (module),
    INDEX idx_audit_date (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE hris_departments
    ADD CONSTRAINT fk_departments_head_employee
    FOREIGN KEY (head_employee_id) REFERENCES hris_employees(id) ON DELETE SET NULL;

ALTER TABLE hris_users
    ADD CONSTRAINT fk_users_employee
    FOREIGN KEY (employee_id) REFERENCES hris_employees(id) ON DELETE SET NULL;
