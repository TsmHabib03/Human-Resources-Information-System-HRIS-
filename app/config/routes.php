<?php

declare(strict_types=1);

return [
    'GET' => [
        '/' => ['controller' => 'DashboardController', 'method' => 'index', 'middleware' => ['auth']],
        '/login' => ['controller' => 'AuthController', 'method' => 'showLogin', 'middleware' => ['guest']],
        '/logout' => ['controller' => 'AuthController', 'method' => 'logout', 'middleware' => ['auth']],

        '/employees' => ['controller' => 'EmployeeController', 'method' => 'index', 'middleware' => ['auth', 'permission:employees.view']],
        '/employees/create' => ['controller' => 'EmployeeController', 'method' => 'create', 'middleware' => ['auth', 'permission:employees.create']],
        '/employees/{id}' => ['controller' => 'EmployeeController', 'method' => 'show', 'middleware' => ['auth', 'permission:employees.view']],
        '/employees/{id}/edit' => ['controller' => 'EmployeeController', 'method' => 'edit', 'middleware' => ['auth', 'permission:employees.update']],

        '/attendance' => ['controller' => 'AttendanceController', 'method' => 'index', 'middleware' => ['auth', 'permission:attendance.view']],

        '/leave' => ['controller' => 'LeaveController', 'method' => 'index', 'middleware' => ['auth', 'permission:leave.view']],

        '/payroll' => ['controller' => 'PayrollController', 'method' => 'index', 'middleware' => ['auth', 'permission:payroll.view']],

        '/settings' => ['controller' => 'SettingsController', 'method' => 'index', 'middleware' => ['auth', 'permission:settings.manage']],
    ],
    'POST' => [
        '/login' => ['controller' => 'AuthController', 'method' => 'login', 'middleware' => ['guest', 'csrf']],

        '/employees' => ['controller' => 'EmployeeController', 'method' => 'store', 'middleware' => ['auth', 'csrf', 'permission:employees.create']],
        '/employees/{id}/update' => ['controller' => 'EmployeeController', 'method' => 'update', 'middleware' => ['auth', 'csrf', 'permission:employees.update']],
        '/employees/{id}/delete' => ['controller' => 'EmployeeController', 'method' => 'destroy', 'middleware' => ['auth', 'csrf', 'permission:employees.delete']],

        '/attendance' => ['controller' => 'AttendanceController', 'method' => 'store', 'middleware' => ['auth', 'csrf', 'permission:attendance.manage']],

        '/leave/request' => ['controller' => 'LeaveController', 'method' => 'store', 'middleware' => ['auth', 'csrf', 'permission:leave.request']],
        '/leave/{id}/approve' => ['controller' => 'LeaveController', 'method' => 'approve', 'middleware' => ['auth', 'csrf', 'permission:leave.approve']],
        '/leave/{id}/reject' => ['controller' => 'LeaveController', 'method' => 'reject', 'middleware' => ['auth', 'csrf', 'permission:leave.approve']],

        '/payroll/grades' => ['controller' => 'PayrollController', 'method' => 'storeGrade', 'middleware' => ['auth', 'csrf', 'permission:payroll.view']],
        '/payroll/salaries' => ['controller' => 'PayrollController', 'method' => 'storeSalary', 'middleware' => ['auth', 'csrf', 'permission:payroll.view']],

        '/settings/company' => ['controller' => 'SettingsController', 'method' => 'saveCompany', 'middleware' => ['auth', 'csrf', 'permission:settings.manage']],
        '/settings/system' => ['controller' => 'SettingsController', 'method' => 'saveSystem', 'middleware' => ['auth', 'csrf', 'permission:settings.manage']],
        '/settings/roles/{id}/toggle' => ['controller' => 'SettingsController', 'method' => 'toggleRole', 'middleware' => ['auth', 'csrf', 'permission:settings.manage']],
    ],
];
