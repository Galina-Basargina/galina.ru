<?php
header('Content-Type: application/json');

$db_conn = pg_connect("host=127.0.0.1 dbname=php_site user=postgres password=postgres")
    or die("Connection error: " . pg_last_error());

// var_dump($db_conn);

if (isset($_GET['action']))
{
    if ($_GET['action'] == 'all')
    {
        $result = pg_query($db_conn, "SELECT s.id, s.sity, c.country FROM sities as s, countries as c where s.country=c.id");
        while ($row = pg_fetch_assoc($result)) {
        echo "<div class='article'>
            <h2>{$row['id']} {$row['sity']}</h2>
            <p>{$row['country']}</p>
            </div>";
        }
    
    }
    else if ($_GET['action'] == 'get' && isset($_GET['id']))
    {
        $id = $_GET['id'];
        $result = pg_query($db_conn, "SELECT s.id, s.sity, c.country FROM sities as s, countries as c where s.country=c.id and s.id=$id");
        while ($row = pg_fetch_assoc($result)) {
        echo "<div class='article'>
            <h2>{$row['id']} {$row['sity']}</h2>
            <p>{$row['country']}</p>
            </div>";
        }
    }
    else if ($_GET['action'] == 'del' && isset($_GET['id']))
    {
        $id = $_GET['id'];
        $result = pg_query($db_conn, "DELETE from sities where id=$id");
        if ($result) {
            echo "Значение из таблицы 'sities' успешно удалено!";
         } else {
            echo "Ошибка при удалении значения: " . pg_last_error($db_conn);
         }
    }
    else if ($_GET['action'] == 'del' && isset($_GET['id']))
    {
        $id = $_GET['id'];
        $result = pg_query($db_conn, "DELETE from sities where id=$id");
        if ($result) {
            echo "Значение из таблицы 'sities' успешно удалено!";
         } else {
            echo "Ошибка при удалении значения: " . pg_last_error($db_conn);
         }
    }
    else if ($_GET['action'] == 'edit' && isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        // valide
        if (empty($data['sity']) || empty($data['country'])) {
            http_response_code(400);
            die(json_encode(['error' => 'Missing sity or country']));
        }
        $id = $_GET['id'];
        $sity = pg_escape_string($data['sity']);
        $country = $data['country'];

        $result = pg_query_params($db_conn,
            "UPDATE sities SET sity = $1, country = $2 WHERE id = $3",
            array($sity, $country, $id)
        );
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Record updated']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Update failed: ' . pg_last_error($db_conn)]);
        }
    }
}
else
{
    if (!isset($_GET['country'])) {
        http_response_code(400);
        die(json_encode(['error' => 'country are required']));
    }

    $country=$_GET['country'];
    $result = pg_query($db_conn, "SELECT s.id, s.sity, c.country FROM sities as s, countries as c where s.country=c.id and c.id=$country");
    while ($row = pg_fetch_assoc($result)) {
    echo "<div class='article'>
            <h2>{$row['id']} {$row['sity']}</h2>
        <p>{$row['country']}</p>
        </div>";
    }
}
?>