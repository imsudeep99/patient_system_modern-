<?php
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /patient_system_modern/views/patients/index.php');
    exit;
}

$name   = trim($_POST['name'] ?? '');
$age    = (int)($_POST['age'] ?? 0);
$gender = trim($_POST['gender'] ?? '');
$contact = trim($_POST['contact'] ?? '');
// $imaging = trim($_POST['imaging'] ?? '');
$referred_by_id = !empty($_POST['referred_by_id']) ? (int)$_POST['referred_by_id'] : null;
$aadhaar = trim($_POST['aadhaar'] ?? '');
$fees = $_POST['fees'] !== '' ? (float)$_POST['fees'] : null;
$discount = $_POST['discount'] !== '' ? (float)$_POST['discount'] : null;
$notes = trim($_POST['notes'] ?? '');

if ($name === '' || $age <= 0 || $gender === '' || $contact === '') {
    $_SESSION['error'] = 'Please fill all required fields.';
    header('Location: /patient_system_modern/views/patients/add.php');
    exit;
}


// -----------------------------------------
//  FILE UPLOAD FIX (MAIN PART)
// -----------------------------------------

$imaging = null;

if (!empty($_FILES['imaging_file']['name'])) {

    $ext = strtolower(pathinfo($_FILES['imaging_file']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'pdf', 'dcm'];

    if (in_array($ext, $allowed)) {

        $uploadDir = __DIR__ . '/../uploads/patient_files/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = 'IMG_' . time() . '_' . rand(1000,9999) . '.' . $ext;
        $destination = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['imaging_file']['tmp_name'], $destination)) {
            $imaging = $filename;   // <-- SAVE THIS TO DATABASE
        }
    }
}


$stmt = $pdo->prepare('INSERT INTO patients 
    (name, age, gender, contact, imaging, referred_by_id, aadhaar, fees, discount, notes, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
$stmt->execute([$name, $age, $gender, $contact, $imaging, $referred_by_id, $aadhaar, $fees, $discount, $notes]);

header('Location: /patient_system_modern/views/patients/index.php');
exit;
