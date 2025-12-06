<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

require_login();

$user = current_user();
$role = $user['role'] ?? 'employee';

if ($role === 'admin') {
    include __DIR__ . '/views/admin/dashboard.php';
} else {
    include __DIR__ . '/views/employee/dashboard.php';
}
