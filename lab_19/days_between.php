<?php
header('Content-Type: application/json');

if (!isset($_GET['date1']) || !isset($_GET['date2'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Both date parameters are required']));
}

$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

try {
    $d1 = new DateTime($date1);
    $d2 = new DateTime($date2);
    $interval = $d1->diff($d2);
    
    echo json_encode([
        'date1' => $date1,
        'date2' => $date2,
        'days_between' => $interval->days,
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid date format']);
}