<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/patient_system_modern/views/admin/employees.php');
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$role = 'employee';

if ($name === '' || $email === '' || $password === '') {
    $_SESSION['error'] = 'All fields are required.';
    redirect('/patient_system_modern/views/admin/employee_add.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $email, $hashed, $role]);

redirect('/patient_system_modern/views/admin/employees.php');
