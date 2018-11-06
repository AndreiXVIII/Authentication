<?php
	session_start();
	include 'connect.php';
	
	$id = $_SESSION['id'];
	
	$query = "SELECT * FROM users WHERE id='$id'";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	$user = mysqli_fetch_assoc($result);
	
	//Проверка на то, что формы заполнены и отправлены
	if (!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['confirmPassword'])) {
		$hash = $user['password'];
		//Проверка, если введенный пароль совпадает с паролем из базы данных
		if (password_verify($_POST['oldPassword'], $hash)) {
			//Проверка на длину нового пароля. Так же, длина должна быть от 6 до 12 символов
			if (strlen($_POST['newPassword']) >= 6 && strlen($_POST['newPassword']) <= 12) {
				//Новый пароль должен совпадать с его повторным введением. Перестраховываем пользователя от случайной ошибки при вводе пароля 
				if ($_POST['newPassword'] == $_POST['confirmPassword']) {
					//Хэшируем новый пароль
					$newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
					
					$query = "UPDATE users SET password='$newPassword' WHERE id='$id'";
					$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
					echo "<p style=\"color:green\"> password changed successfully </p>";
				}
				else {
					echo "<p style=\"color:red\"> new passwords do not match </p>";
				}
			}
			else {
				echo "<p style=\"color:red\"> Your password must contain from 6 to 12 characters </p>";
			}
		}
		else {
			echo "<p style=\"color:red\"> You entered a wrong password </p>";
		}
	}	
?><head>
	<meta charset="utf-8">
</head>
<form action="" method="POST">
	<p> Enter old password </p>
	<input type="password" name="oldPassword" value="<?php if(!empty($_POST['oldPassword'])) echo $_POST['oldPassword']; ?>">
	<p> Enter new password </p>
	<input type="password" name="newPassword" value="<?php if(!empty($_POST['newPassword'])) echo $_POST['newPassword']; ?>">
	<p> Confirm new password </p>
	<input type="password" name="confirmPassword" value="<?php if(!empty($_POST['confirmPassword'])) echo $_POST['confirmPassword']; ?>">
	<p></p>
	<input type="submit">
</form>
<br>
<a href="personalArea.php"> Вернуться в свой профиль </a>