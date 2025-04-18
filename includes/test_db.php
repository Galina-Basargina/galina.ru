<?php
$conn = pg_connect("host=localhost dbname=php_site  user=postgres password=postgres");
if (!$conn) {
    die("Ошибка подключения: " . pg_last_error());
}
echo "Подключение к PostgreSQL успешно!";
pg_close($conn);
?>
