<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers.php';

require_login();

$page_title = 'Doctors / ASHA';
$active = 'referrers';

$referrers = $pdo->query('SELECT * FROM referrers ORDER BY type, name')->fetchAll();

$rows = '';
foreach ($referrers as $r) {
    $rows .= '<tr>
        <td>'.htmlspecialchars($r['name']).'</td>
        <td>'.htmlspecialchars(strtoupper($r['type'])).'</td>
        <td>'.htmlspecialchars($r['phone']).'</td>
        <td>'.htmlspecialchars($r['hospital_clinic']).'</td>
        <td>'.htmlspecialchars($r['address']).'</td>
    </tr>';
}

$content = <<<HTML
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="mb-0">Doctors / ASHA List</h6>
    <a href="/patient_system_modern/views/referrers/add.php" class="btn btn-primary btn-sm">
        <i class="bi bi-plus"></i> Add
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>Hospital / Clinic</th>
                        <th>Address</th>
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
