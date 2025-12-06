<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers.php';

require_login('admin');

$page_title = 'Employees';
$active = 'employees';

// Fetch employees
$stmt = $pdo->query("SELECT id, name, email, role, created_at FROM users WHERE role = 'employee' ORDER BY id DESC");
$employees = $stmt->fetchAll();

$rows = '';
foreach ($employees as $e) {
    $rows .= '<tr>
                <td>'.htmlspecialchars($e['name']).'</td>
                <td>'.htmlspecialchars($e['email']).'</td>
                <td>'.htmlspecialchars($e['role']).'</td>
                <td>'.htmlspecialchars(date("d-m-Y", strtotime($e["created_at"]))).'</td>
              </tr>';
}

$content = <<<HTML
<div class="d-flex justify-content-between mb-3">
    <h6 class="mb-0">Employee List</h6>
    <a href="/patient_system_modern/views/admin/employee_add.php" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Add Employee
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                {$rows}
            </tbody>
        </table>
    </div>
</div>
HTML;

include __DIR__ . '/../layout/main.php';
