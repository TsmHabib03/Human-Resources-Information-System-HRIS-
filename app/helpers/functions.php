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
