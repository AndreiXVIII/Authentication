<?php
	session_start();
	include 'connect.php';

	//Проверка на то, что формы заполнены и отправлены	
	if (!empty($_POST['login']) AND !empty($_POST['password'])) {
		$login = $_POST['login'];
		
		$query = "SELECT * FROM users WHERE login='$login'";
		$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
		$user = mysqli_fetch_assoc($result);
		
		//Проверяем на то, что пользователь с таким логином есть, и если есть - получаем хэшированный пароль из БД для дальнейшей авторизации		
		if (!empty($user)) {
			$passwordFromDatabase = $user['password'];
			//Проверяем на совпадение введенного пароля и хешированного из базы данных
			if (password_verify($_POST['password'], $passwordFromDatabase)) {
				//Проверяем, что пользователь не забанен
				if ($user['banned'] != 1) {
					$_SESSION['auth'] = true;
					$_SESSION['login'] = $login;
					$_SESSION['id'] = $user['id'];
					$_SESSION['status'] = $user['status'];
					header ('Location: index.php');
				}
				else {
					echo "<p> Пользователь забанен </p>";
				}
			}
			else {
				$_SESSION['auth'] = null;
				echo "<p> Повторите попытку </p>";
			}
		}
		else {
			echo "<p> Повторите попытку </p>";
		}
	}
?>
<head>
	<meta charset="utf-8">
</head>
<form action="" method="POST">
	<input name="login" placeholder="login">
	<input type="password" name="password" placeholder="password">
	<input type="submit" value="Авторизировать">
</form>
