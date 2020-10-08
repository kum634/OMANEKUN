<?php
require("conf.php");
$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
$pdo->query ("set character set utf8");
?>
