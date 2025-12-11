<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request");
}

$id = intval($_POST['id']);

$stmt = $pdo->prepare("
    UPDATE users SET 
        name = ?, 
        email  = ?, 
        password = ?, 
        role = ?
    WHERE id = ?
");

$stmt->execute([
    $_POST['name'],
    $_POST['email'],
    $_POST['password'],
    $_POST['role'],
    $_POST['id']
]);

header("Location: employees.php");
exit;
