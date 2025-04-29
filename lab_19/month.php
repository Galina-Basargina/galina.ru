<?php
header('Content-Type: application/json');

$response = [
    'month' => date('m'),
];

echo json_encode($response);