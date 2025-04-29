<?php
// phpinfo();
// setup-db.php
include 'includes/db.php';

// SQL-запрос для создания таблицы стран
$query = <<<SQL
CREATE TABLE IF NOT EXISTS public.countries (
   id SERIAL PRIMARY KEY,
   country VARCHAR(255) NOT NULL
)
SQL;
// Выполнение запроса
$result = pg_query($db_conn, $query);


if ($result) {
   echo "Таблица 'countries' успешно создана или уже существует!";
} else {
   echo "Ошибка при создании таблицы: " . pg_last_error($db_conn);
}
// // Закрытие соединения (опционально)
// pg_close($db_conn);



// SQL-запрос для создания таблицы городов
$query = <<<SQL
CREATE TABLE IF NOT EXISTS public.sities (
   id SERIAL PRIMARY KEY,
   sity VARCHAR(255) NOT NULL,
   country int references countries(id)
)
SQL;
// Выполнение запроса
$result = pg_query($db_conn, $query);


if ($result) {
   echo "Таблица 'sities' успешно создана или уже существует!";
} else {
   echo "Ошибка при создании таблицы: " . pg_last_error($db_conn);
}
// Закрытие соединения (опционально)
pg_close($db_conn);
?>
