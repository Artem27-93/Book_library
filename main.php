<?php
include 'config.php';

$sql = $pdo->prepare("SELECT * FROM `books_lib`");
$sql->execute();
$result = $sql->fetchAll();
// DELETE
if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM books_lib WHERE id=?";
	$query = $pdo->prepare($sql);
	$query->execute([$get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}


