<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';

require_login();

// CSV headers
$filename = "patients_" . date("Y-m-d_H-i-s") . ".csv";
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");

// Output stream
$output = fopen("php://output", "w");

// -----------------------------------------------------------
// UPPERCASE headings (CSV cannot store real bold formatting)
// -----------------------------------------------------------
fputcsv($output, [
    'ID',
    'NAME',
    'GENDER',
    'AGE',
    'CONTACT',
    'REFERRER',
    'FEES',
    'DISCOUNT',
    'AADHAAR',
    'CREATED_AT'
]);

// ----------------------
// FILTER SECTION
// ----------------------
$where = [];
$params = [];

// DATE + TIME filter
if (!empty($_GET['from'])) {
    $where[] = 'p.created_at >= :from';
    $params[':from'] = $_GET['from'] . " 23:59:59";
}

if (!empty($_GET['to'])) {
    $where[] = 'p.created_at <= :to';
    $params[':to'] = $_GET['to'] . " 23:59:59";
}


// ----------------------
// SQL QUERY
// ----------------------
$sql = "
    SELECT 
        p.id,
        p.name,
        p.gender,
        p.age,
        p.contact,
        r.name AS referrer,
        p.fees,
        p.discount,
        p.aadhaar,
        p.created_at
    FROM patients p
    LEFT JOIN referrers r ON r.id = p.referred_by_id
";

if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY p.id DESC";

// Execute
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

// -----------------------------------------------------------
// Write rows with formatted date
// -----------------------------------------------------------
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    if (!empty($row['created_at'])) {
        // $row['created_at'] = date("d-m-Y h:i A", strtotime($row['created_at']));
        $row['created_at'] = '="'.date("d-m-Y h:i A", strtotime($row['created_at'])).'"';

    }

    fputcsv($output, $row);
}

fclose($output);
exit;
