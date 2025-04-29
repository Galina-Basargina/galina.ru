<?php
// phpinfo();
// setup-db.php
include 'includes/db.php';

// SQL-запрос для создания таблицы стран
$query = <<<SQL
insert into countries (country) values 
('Russia'),
('China'),
('USA'),
('Japan');
SQL;
// Выполнение запроса
$result = pg_query($db_conn, $query);


if ($result) {
   echo "Значения в таблицу 'countries' успешно добавились!";
} else {
   echo "Ошибка при добавлении значений: " . pg_last_error($db_conn);
}
// // Закрытие соединения (опционально)
// pg_close($db_conn);



// SQL-запрос для создания таблицы городов
$query = <<<SQL
INSERT INTO sities (sity, country) VALUES
('Moscow', 1),         -- Russia
('Saint Petersburg', 1),-- Russia
('Novosibirsk', 1),     -- Russia
('Beijing', 2),         -- China
('Shanghai', 2),        -- China
('Guangzhou', 2),       -- China
('New York', 3),        -- USA
('Los Angeles', 3),     -- USA
('Chicago', 3),         -- USA
('Tokyo', 4);           -- Japan
SQL;
// Выполнение запроса
$result = pg_query($db_conn, $query);


if ($result) {
   echo "Данны в таблицу 'sities' успешно добавлены!";
} else {
   echo "Ошибка при добавлении данных: " . pg_last_error($db_conn);
}
// Закрытие соединения (опционально)
pg_close($db_conn);
?>
