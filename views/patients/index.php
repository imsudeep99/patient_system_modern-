<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers.php';

require_login();

$page_title = 'Patients';
$active = 'patients';

$stmt = $pdo->query('SELECT p.*, r.name AS referrer_name, r.type AS referrer_type FROM patients p 
    LEFT JOIN referrers r ON p.referred_by_id = r.id ORDER BY p.created_at DESC');
$patients = $stmt->fetchAll();

$rows = '';
foreach ($patients as $p) {
    $ref = $p['referrer_name'] ? $p['referrer_name'] . ' (' . strtoupper($p['referrer_type']) . ')' : '-';
    $rows .= '<tr>
        <td>'.htmlspecialchars($p['name']).'</td>
        <td>'.htmlspecialchars($p['age']).'</td>
        <td>'.htmlspecialchars($p['gender']).'</td>
        <td>'.htmlspecialchars($p['contact']).'</td>
        <td>'.htmlspecialchars($ref).'</td>
        <td>'.htmlspecialchars($p['fees']).'</td>
        <td>'.htmlspecialchars(date('d-m-Y', strtotime($p['created_at']))).'</td>
    </tr>';
}

$content = <<<HTML
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0">Patient List</h6>
    <a href="/patient_system_modern/views/patients/add.php" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Add Patient
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Referred By</th>
                        <th>Fees</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {$rows}
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

include __DIR__ . '/../layout/main.php';
