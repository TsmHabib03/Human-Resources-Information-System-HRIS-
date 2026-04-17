<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Session;
use App\Models\Subscription;

final class SubscriptionMiddleware
{
    public static function handle(): bool
    {
        if (!Auth::check()) {
            header('Location: /login');
            return false;
        }

        $path = (string) (parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/');
        $path = rtrim($path, '/') ?: '/';

        if ($path === '/billing' || str_starts_with($path, '/billing/')) {
            return true;
        }

        $userId = Auth::id();

        if ($userId === null) {
            Session::flash('error', 'Session context is invalid. Please sign in again.');
            header('Location: /login');
            return false;
        }

        $subscription = new Subscription();
        $companyId = $subscription->resolveCompanyIdForUser($userId);

        if ($companyId === null) {
            Session::flash('error', 'Company profile was not found. Please configure billing access first.');
            header('Location: /billing');
            return false;
        }

        if ($subscription->hasValidAccessForCompany($companyId)) {
            return true;
        }

        Session::flash('error', 'Your subscription is not active. Select a quarterly plan to continue.');
        header('Location: /billing');

        return false;
    }
}
