<?php
header('Content-Type: application/json');

$response = [
    'day' => date('d'),
];

echo json_encode($response);