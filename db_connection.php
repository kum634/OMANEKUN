<?php
$this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
$this->pdo->query("set character set utf8");
?>
