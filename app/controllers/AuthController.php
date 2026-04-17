<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Session;

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            if (super_admin_only_mode_enabled() && !is_super_admin_user(Auth::user())) {
                Auth::logout();
                Session::flash('error', 'Only the Super Admin account can access this environment right now.');
                $this->redirect('/login');
            }

            $this->redirect(post_auth_entry_path(Auth::user()));
        }

        $this->view('auth/login', [
            'title' => 'Sign in',
            'csrf' => CSRF::token(),
            'error' => Session::pullFlash('error'),
        ], 'auth');
    }

    public function login(): void
    {
        $token = $_POST['_csrf'] ?? null;
        if (!CSRF::verify(is_string($token) ? $token : null)) {
            Session::flash('error', 'Your session token is invalid. Please try again.');
            $this->redirect('/login');
        }

        $identity = trim((string) ($_POST['identity'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($identity === '' || $password === '') {
            Session::flash('error', 'Username or email and password are required.');
            $this->redirect('/login');
        }

        if (!Auth::attempt($identity, $password)) {
            Session::flash('error', 'Invalid credentials or account is temporarily locked.');
            $this->redirect('/login');
        }

        $user = Auth::user();

        if (super_admin_only_mode_enabled() && !is_super_admin_user($user)) {
            Auth::logout();
            Session::flash('error', 'Only the Super Admin account can access this environment right now.');
            $this->redirect('/login');
        }

        $this->redirect(post_auth_entry_path($user));
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
