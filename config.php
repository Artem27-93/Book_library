<?php

try {
	$pdo = new PDO('mysql:dbname=booksdb; host=localhost', 'admin', 'Qwerty27');
} catch (PDOException $e) {
	die($e->getMessage());
}