<?php
	session_start();
	include 'connect.php';
	
	$query = "SELECT * FROM users";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	for ($array = []; $row = mysqli_fetch_assoc($result); $array[] = $row);
	
	//Вывод всех зарегистрированных пользователей через ссылки, переходя по которым можем смотреть информацию о пользователе
	foreach ($array as $elem) {
		echo "<a href=\"profile.php?id={$elem['id']}\"> {$elem['login']} </a>".'<br>';
	}
?>
	
	
	