<?php
header('Content-Type: text/plain');

// Упрощенная валидация
$errors = [];

if (empty($_POST['name'])) {
    $errors[] = 'Имя обязательно для заполнения';
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Некорректный email';
}

if (empty($_POST['message'])) {
    $errors[] = 'Сообщение не может быть пустым';
}

if (!empty($errors)) {
    http_response_code(400);
    die(implode("\n", $errors));
}

// Если все хорошо - просто возвращаем успех
echo "OK";

