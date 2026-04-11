<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Audit;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Settings;

final class SettingsController extends Controller
{
    private Settings $settings;

    public function __construct()
    {
        $this->settings = new Settings();
    }

    public function index(): void
    {
        $this->view('settings/index', [
            'title' => 'Settings',
            'csrf' => CSRF::token(),
            'company' => $this->settings->companyProfile(),
            'roles' => $this->settings->rolesWithPermissionCount(),
            'system' => $this->settings->loadSystemSettings(),
            'success' => Session::pullFlash('success'),
            'error' => Session::pullFlash('error'),
            'errors' => Session::pullFlash('errors', []),
        ]);
    }

    public function saveCompany(): void
    {
        $data = [
            'company_name' => trim((string) ($_POST['company_name'] ?? '')),
            'address' => trim((string) ($_POST['address'] ?? '')),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'website' => trim((string) ($_POST['website'] ?? '')),
            'logo_path' => trim((string) ($_POST['logo_path'] ?? '')),
        ];

        $errors = Validator::required($data, ['company_name']);
        $errors = array_merge($errors, Validator::email($data, 'email'));

        if ($errors !== []) {
            Session::flash('errors', $errors);
            Session::flash('error', 'Please fix company settings errors.');
            $this->redirect('/settings');
        }

        $companyId = $this->settings->saveCompany($data);
        Audit::log('settings', 'UPDATE', $companyId, null, $data);

        Session::flash('success', 'Company settings saved.');
        $this->redirect('/settings');
    }

    public function saveSystem(): void
    {
        $data = [
            'timezone' => trim((string) ($_POST['timezone'] ?? 'Asia/Manila')),
            'date_format' => trim((string) ($_POST['date_format'] ?? 'Y-m-d')),
            'default_currency' => trim((string) ($_POST['default_currency'] ?? 'PHP')),
        ];

        $errors = Validator::required($data, ['timezone', 'date_format', 'default_currency']);

        if ($errors !== []) {
            Session::flash('errors', $errors);
            Session::flash('error', 'Please fix system settings errors.');
            $this->redirect('/settings');
        }

        if (!$this->settings->saveSystemSettings($data)) {
            Session::flash('error', 'Unable to save system settings.');
            $this->redirect('/settings');
        }

        Audit::log('settings', 'UPDATE', null, null, $data);

        Session::flash('success', 'System settings saved.');
        $this->redirect('/settings');
    }

    public function toggleRole(string $id): void
    {
        $roleId = (int) $id;
        $before = $this->settings->findRole($roleId);

        if (!$before) {
            Session::flash('error', 'Role not found.');
            $this->redirect('/settings');
        }

        $this->settings->toggleRoleActive($roleId);
        $after = $this->settings->findRole($roleId);
        Audit::log('settings', 'UPDATE', $roleId, $before, $after);

        Session::flash('success', 'Role status updated.');
        $this->redirect('/settings');
    }
}
