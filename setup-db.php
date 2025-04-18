<?php
// phpinfo();
// setup-db.php
include 'includes/db.php';
// SQL-запрос для создания таблицы статей
$query = <<<SQL
CREATE TABLE IF NOT EXISTS public.articles (
   id SERIAL PRIMARY KEY,
   title VARCHAR(255) NOT NULL,
   content TEXT,
   created_at TIMESTAMP DEFAULT NOW()
)
SQL;
// echo 1;
// Выполнение запроса
$result = pg_query($db_conn, $query);


if ($result) {
   echo "Таблица 'articles' успешно создана или уже существует!";
} else {
   echo "Ошибка при создании таблицы: " . pg_last_error($db_conn);
}
// Закрытие соединения (опционально)
pg_close($db_conn);
?>
