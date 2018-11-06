<?php
	session_start();
	include 'connect.php';
	
	//Форма в отдельной переменной для того, чтобы при успешном удалении ее больше не показывать
	$form = "<div>
				<h3> Подтвердите удаление аккаунта </h3>
				<form action=\"\" method=\"POST\">
					<input type=\"password\" name=\"password\" placeholder=\"enter password\"><br><br>
					<input type=\"submit\">
				</form>
			</div>";
	
	$id = $_SESSION['id'];
	
	$query = "SELECT * FROM users WHERE id='$id'";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	$user = mysqli_fetch_assoc($result);
	
	$hash = $user['password'];
	
	//Подтверждение удаления аккаунта через введение пароля: если введенный пароль совпадает с паролем из базы данных - удаляем. Защита от злоумышленника.
	if (password_verify($_POST[password], $hash)) {
		$query = "DELETE FROM users WHERE id='$id'";
		$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
		echo "<p style=\"color:green\"> account successfully deleted </p>";
		$form = '';
		$deleted = "<a href=\"logout.php\"> Выход </a>";
	}
	else {
		$back = "<a href=\"personalArea.php\"> Вернуться в свой профиль </a>";
	}
?>
<head>
	<meta charset="utf-8">
</head>
<?= $form; ?>
<br>
<?= $deleted; ?>
<br>
<?= $back; ?>
