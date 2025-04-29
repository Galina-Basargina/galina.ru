<?php
header('Content-Type: application/json');

$response = [
    'year' => date('Y'),
];

echo json_encode($response);