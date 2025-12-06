<?php
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /patient_system_modern/views/referrers/index.php');
    exit;
}

$type = trim($_POST['type'] ?? '');
$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$hospital = trim($_POST['hospital_clinic'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($type === '' || $name === '') {
    $_SESSION['error'] = 'Type and name are required.';
    header('Location: /patient_system_modern/views/referrers/add.php');
    exit;
}

$stmt = $pdo->prepare('INSERT INTO referrers (type, name, phone, hospital_clinic, address, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
$stmt->execute([$type, $name, $phone, $hospital, $address]);

header('Location: /patient_system_modern/views/referrers/index.php');
exit;
