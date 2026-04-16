# HRIS v1

Custom Human Resources Information System foundation with PHP MVC, MySQL, and a dark dashboard scaffold.

## Stack
- PHP 8.1+
- MySQL 8+
- Apache with mod_rewrite
- Composer with vlucas/phpdotenv

## Quick Start
1. Copy .env.example to .env and set database credentials.
2. Run composer install.
3. Create database hris_db.
4. Import database/migrations/001_initial_schema.sql.
5. Run database/seeds/roles_seed.sql.
6. Run database/seeds/demo_data.sql.
7. Point Apache vhost to project root and open app URL.

## Seeded Accounts
- Super Admin: superadmin / Admin@123
- Manager: manager1 / Admin@123
- Employee: employee1 / Admin@123

Manager and Employee records are seeded from database/seeds/demo_data.sql and are safe to re-run because inserts are idempotent.

## Current Status
- Phase 1 schema and seeds created.
- Phase 2 folder architecture created.
- Phase 3 CSS and dashboard shell initialized.
- Phase 4 core runtime, auth controller, and front controller initialized.

## Next Chunk
- Implement employee CRUD and route-level permission gates.
