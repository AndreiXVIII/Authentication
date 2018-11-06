<?php
	session_start();
	include 'connect.php';

	//Показывает карточку пользователя	
	$id = $_GET['id'];
	
	$query = "SELECT * FROM users WHERE id='$id'";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	$user = mysqli_fetch_assoc($result);
	
	$now = date('Y-m-d');
	$usersOld = $now - $user['birthday'];
	
	echo "<h3> Карточка пользователя </h3>";
	echo "<hr>";
	echo "Логин: {$user['login']}".'<br>';
	echo "Имя: {$user['name']}".'<br>';
	echo "Фамилия: {$user['surname']}".'<br>';
	echo "Отчество: {$user['patronymic']}".'<br>';
	echo "Пользователю лет: $usersOld".'<br><hr>';
	
?>
<head>
	<meta charset="utf-8">
</head>