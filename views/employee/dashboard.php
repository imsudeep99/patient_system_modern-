<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers.php';

require_login('employee');

$page_title = 'Employee Dashboard';
$active = 'dashboard';

$content = <<<HTML
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title mb-3">Quick Actions</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="/patient_system_modern/views/patients/add.php" class="quick-link">
                    <div class="quick-card">
                        <i class="bi bi-person-plus"></i>
                        <span>Add Patient</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/patient_system_modern/views/referrers/add.php" class="quick-link">
                    <div class="quick-card">
                        <i class="bi bi-person-video2"></i>
                        <span>Add Doctor / ASHA</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/patient_system_modern/views/patients/index.php" class="quick-link">
                    <div class="quick-card">
                        <i class="bi bi-card-list"></i>
                        <span>View Patients</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
HTML;

include __DIR__ . '/../layout/main.php';
