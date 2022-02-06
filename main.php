<?php
include 'config.php';
//загрузка данных из справочника книг
$sql = $pdo->prepare("SELECT * FROM `books_lib`");
$sql->execute();
$result = $sql->fetchAll();

//загрузка данных из справочника авторов
$sql = $pdo->prepare("SELECT * FROM `authors`");
$sql->execute();
$result_auth = $sql->fetchAll();





