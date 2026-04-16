<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Audit;
use App\Core\Auth;
use App\Core\Controller;
use App\Core\CSRF;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Employee;
use App\Models\LeaveRequest;

final class LeaveController extends Controller
{
    private const PER_PAGE = 10;

    private LeaveRequest $leaveRequests;
    private Employee $employees;

    public function __construct()
    {
        $this->leaveRequests = new LeaveRequest();
        $this->employees = new Employee();
    }

    public function index(): void
    {
        $status = trim((string) ($_GET['status'] ?? ''));
        $query = trim((string) ($_GET['q'] ?? ''));
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $employeeScopeId = $this->employeeScopeId();
        $scopeFilterId = $employeeScopeId;
        $employeeOptions = $this->employees->listSimple();
        $currentEmployee = null;
        $isSelfService = $employeeScopeId !== null;

        if ($isSelfService) {
            $query = '';

            if (($employeeScopeId ?? 0) > 0) {
                $currentEmployee = $this->employees->find((int) $employeeScopeId);
                $employeeOptions = $currentEmployee ? [$currentEmployee] : [];
            } else {
                $scopeFilterId = -1;
                $employeeOptions = [];
            }
        }

        $total = $this->leaveRequests->countFiltered($status, $query, $scopeFilterId);
        $totalPages = max(1, (int) ceil($total / self::PER_PAGE));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $this->view('leave/index', [
            'title' => 'Leave Management',
            'csrf' => CSRF::token(),
            'requests' => $this->leaveRequests->listFiltered($status, $query, $page, self::PER_PAGE, $scopeFilterId),
            'leaveTypes' => $this->leaveRequests->leaveTypes(),
            'statusOptions' => $this->leaveRequests->statuses(),
            'employees' => $employeeOptions,
            'currentEmployee' => $currentEmployee,
            'isSelfService' => $isSelfService,
            'query' => $query,
            'status' => $status,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'success' => Session::pullFlash('success'),
            'error' => Session::pullFlash('error'),
            'errors' => Session::pullFlash('errors', []),
            'old' => Session::pullFlash('old', []),
        ]);
    }

    public function store(): void
    {
        $data = [
            'employee_id' => trim((string) ($_POST['employee_id'] ?? '')),
            'leave_type_id' => trim((string) ($_POST['leave_type_id'] ?? '')),
            'start_date' => trim((string) ($_POST['start_date'] ?? '')),
            'end_date' => trim((string) ($_POST['end_date'] ?? '')),
            'total_days' => trim((string) ($_POST['total_days'] ?? '')),
            'reason' => trim((string) ($_POST['reason'] ?? '')),
        ];

        $employeeScopeId = $this->employeeScopeId();
        if ($employeeScopeId !== null) {
            if ($employeeScopeId <= 0) {
                Session::flash('error', 'Your account is not linked to an employee profile. Contact an administrator.');
                $this->redirect('/leave');
            }

            $data['employee_id'] = (string) $employeeScopeId;
        }

        $errors = Validator::required($data, ['employee_id', 'leave_type_id', 'start_date', 'end_date', 'total_days']);
        $errors = array_merge($errors, Validator::validDate($data, 'start_date'));
        $errors = array_merge($errors, Validator::validDate($data, 'end_date'));
        $errors = array_merge($errors, Validator::dateOrder($data, 'start_date', 'end_date'));
        $errors = array_merge($errors, Validator::numericMin($data, 'total_days', 0.5));

        if ($data['employee_id'] !== '' && !ctype_digit($data['employee_id'])) {
            $errors['employee_id'] = 'Employee value is invalid.';
        }

        if ($data['leave_type_id'] !== '' && !ctype_digit($data['leave_type_id'])) {
            $errors['leave_type_id'] = 'Leave type value is invalid.';
        }

        if ($errors === [] && $this->leaveRequests->hasOverlap((int) $data['employee_id'], $data['start_date'], $data['end_date'])) {
            $errors['start_date'] = 'Overlapping pending/approved leave exists for the selected employee.';
        }

        if ($errors !== []) {
            Session::flash('errors', $errors);
            Session::flash('old', $data);
            Session::flash('error', 'Please complete the leave request form.');
            $this->redirect('/leave');
        }

        $id = $this->leaveRequests->createRequest($data);
        $created = $this->leaveRequests->find($id);
        Audit::log('leave', 'CREATE', $id, null, $created);

        Session::flash('success', 'Leave request submitted.');
        $this->redirect('/leave');
    }

    public function approve(string $id): void
    {
        $leaveId = (int) $id;
        $before = $this->leaveRequests->find($leaveId);

        if (!$before) {
            Session::flash('error', 'Leave request not found.');
            $this->redirect('/leave');
        }

        $remarks = trim((string) ($_POST['review_remarks'] ?? 'Approved'));
        if (!$this->leaveRequests->updateStatus($leaveId, 'Approved', Auth::id(), $remarks)) {
            Session::flash('error', 'Only pending requests can be approved.');
            $this->redirect('/leave');
        }

        $after = $this->leaveRequests->find($leaveId);
        Audit::log('leave', 'UPDATE', $leaveId, $before, $after);

        Session::flash('success', 'Leave request approved.');
        $this->redirect('/leave');
    }

    public function reject(string $id): void
    {
        $leaveId = (int) $id;
        $before = $this->leaveRequests->find($leaveId);

        if (!$before) {
            Session::flash('error', 'Leave request not found.');
            $this->redirect('/leave');
        }

        $remarks = trim((string) ($_POST['review_remarks'] ?? 'Rejected'));
        if (!$this->leaveRequests->updateStatus($leaveId, 'Rejected', Auth::id(), $remarks)) {
            Session::flash('error', 'Only pending requests can be rejected.');
            $this->redirect('/leave');
        }

        $after = $this->leaveRequests->find($leaveId);
        Audit::log('leave', 'UPDATE', $leaveId, $before, $after);

        Session::flash('success', 'Leave request rejected.');
        $this->redirect('/leave');
    }

    private function employeeScopeId(): ?int
    {
        $user = Auth::user();
        if (!is_employee_role($user)) {
            return null;
        }

        return isset($user['employee_id']) ? (int) $user['employee_id'] : 0;
    }
}
