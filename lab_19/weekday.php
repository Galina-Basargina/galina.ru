<?php
header('Content-Type: application/json');

if (!isset($_GET['date'])) {
    http_response_code(400);
    die(json_encode(['error' => 'Missing date parameter']));
}

$date = $_GET['date'];

if (!DateTime::createFromFormat('Y-m-d', $date)) {
    http_response_code(400);
    die(json_encode(['error' => 'Invalid date format. Use YYYY-MM-DD']));
}

$weekday = date('l', strtotime($date));
echo json_encode([
    'date' => $date,
    'weekday' => $weekday
]);