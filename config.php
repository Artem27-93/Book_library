<?php

try {
    //конфиги подключения к бд
	$pdo = new PDO('mysql:dbname=booksdb; host=192.168.0.110', 'admin', 'Qwerty27');
} catch (PDOException $e) {
	die($e->getMessage());
}