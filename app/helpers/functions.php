<?php

declare(strict_types=1);

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? null;

        if ($value === null) {
            return $default;
        }

        $normalized = strtolower((string) $value);

        return match ($normalized) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            'empty', '(empty)' => '',
            default => $value,
        };
    }
}

if (!function_exists('config')) {
    function config(string $file): array
    {
        $path = __DIR__ . '/../config/' . $file . '.php';

        if (!file_exists($path)) {
            throw new RuntimeException('Config file not found: ' . $file);
        }

        $config = require $path;

        if (!is_array($config)) {
            throw new RuntimeException('Config file must return array: ' . $file);
        }

        return $config;
    }
}

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('auth_user')) {
    function auth_user(): ?array
    {
        $user = \App\Core\Auth::user();

        return is_array($user) ? $user : null;
    }
}

if (!function_exists('can')) {
    function can(string $permissionKey): bool
    {
        if ($permissionKey === '') {
            return false;
        }

        return \App\Core\Auth::can($permissionKey);
    }
}

if (!function_exists('is_role')) {
    function is_role(string $roleName, ?array $user = null): bool
    {
        if ($roleName === '') {
            return false;
        }

        $resolvedUser = is_array($user) ? $user : auth_user();
        if ($resolvedUser === null) {
            return false;
        }

        return (string) ($resolvedUser['role_name'] ?? '') === $roleName;
    }
}

if (!function_exists('is_employee_role')) {
    function is_employee_role(?array $user = null): bool
    {
        return is_role('Employee', $user);
    }
}

if (!function_exists('permission_for_path')) {
    function permission_for_path(string $path): ?string
    {
        $normalized = rtrim($path, '/');
        if ($normalized === '') {
            $normalized = '/';
        }

        return match ($normalized) {
            '/employees' => 'employees.view',
            '/attendance' => 'attendance.view',
            '/leave' => 'leave.view',
            '/payroll' => 'payroll.view',
            '/settings' => 'settings.manage',
            default => null,
        };
    }
}

if (!function_exists('can_access_path')) {
    function can_access_path(string $path): bool
    {
        $normalized = rtrim($path, '/');
        if ($normalized === '') {
            $normalized = '/';
        }

        if ($normalized === '/login') {
            return !\App\Core\Auth::check();
        }

        if (!\App\Core\Auth::check()) {
            return false;
        }

        $permission = permission_for_path($normalized);
        if ($permission === null) {
            return $normalized === '/';
        }

        return can($permission);
    }
}

if (!function_exists('role_landing_path')) {
    function role_landing_path(?array $user = null): string
    {
        $resolvedUser = is_array($user) ? $user : auth_user();
        if ($resolvedUser === null) {
            return '/login';
        }

        $preferredPath = match ((string) ($resolvedUser['role_name'] ?? '')) {
            'Super Admin' => '/settings',
            'HR Admin' => '/employees',
            'Manager' => '/leave',
            'Employee' => '/attendance',
            default => '/',
        };

        if (can_access_path($preferredPath)) {
            return $preferredPath;
        }

        $fallbackPaths = ['/', '/employees', '/attendance', '/leave', '/payroll', '/settings'];
        foreach ($fallbackPaths as $path) {
            if (can_access_path($path)) {
                return $path;
            }
        }

        return '/';
    }
}
