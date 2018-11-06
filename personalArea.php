<?php
	session_start();
	include 'connect.php';
	
	$id = $_SESSION['id'];
	
	$query = "SELECT * FROM users WHERE id='$id'";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	
	$user = mysqli_fetch_assoc($result);
	//Проверка на то, что формы заполнены и отправлены, если все хорошо - редактируем нужные данные
	if (!empty($_POST['changeUserName']) && !empty($_POST['changeUserSurname']) && !empty($_POST['changeUserPatronymic']) && !empty($_POST['changeUserBirthday'])) {
		$updateName = $_POST['changeUserName'];
		$updateSurname = $_POST['changeUserSurname'];
		$updatePatronymic = $_POST['changeUserPatronymic'];
		$updateBirthday = $_POST['changeUserBirthday'];
		
		$query = "UPDATE users SET name='$updateName', surname='$updateSurname', patronymic='$updatePatronymic', birthday='$updateBirthday' WHERE id='$id'";
		$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
		
		$updateQuery = "SELECT * FROM users WHERE id='$id'";
		$updateResult = mysqli_query($connect, $updateQuery) or die (mysqli_error($connect));
		$update = mysqli_fetch_assoc($updateResult);
		
		$now = date('Y-m-d');
		$usersOld = $now - $update['birthday'];
		
		echo "<h3> Новые данные </h3>";
		echo "<hr>";
		echo "Имя: {$update['name']}".'<br>';
		echo "Фамилия: {$update['surname']}".'<br>';
		echo "Отчество: {$update['patronymic']}".'<br>';
		echo "Пользователю лет: $usersOld".'<br><hr>';
	}
?>
<head>
	<meta charset="utf-8">
</head>
<h3> Редактировать профиль </h3>
<form action="" method="POST">
	<p><b> Имя: </b></p>
	<input name="changeUserName" value="<?php if (!empty($_POST['changeUserName'])) echo $_POST['changeUserName'] ?>"><br>
	<p><b> Фамилия: </b></p>
	<input name="changeUserSurname" value="<?php if (!empty($_POST['changeUserSurname'])) echo $_POST['changeUserSurname'] ?>"><br>
	<p><b> Отчество: </b></p>
	<input name="changeUserPatronymic" value="<?php if (!empty($_POST['changeUserPatronymic'])) echo $_POST['changeUserPatronymic'] ?>"><br>
	<p><b> Дата рождения: </b></p>
	<input name="changeUserBirthday" value="<?php if (!empty($_POST['changeUserBirthday'])) echo $_POST['changeUserBirthday'] ?>"><br><br>
	<input type="submit" value="Внести изменения">
</form>
<a href="changePassword.php"> Сменить пароль </a><br><br>
<a href="deleteAccount.php"> Удалить аккаунт </a><br><br>
<a href="index.php"> Вернуться на главную страницу	</a>