<?php
$db_conn = pg_connect("host=127.0.0.1 dbname=php_site user=postgres password=postgres")
   or die("Connection error: " . pg_last_error());
?>
