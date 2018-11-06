<?php
	session_start();
	include 'connect.php';
	
	//Проверка на то, что формы заполнены и отправлены
	if (
		!empty($_POST['addLogin']) && !empty($_POST['addPassword']) && !empty($_POST['confirm']) && !empty($_POST['addEmail']) 
		&& !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['patronymic']) && !empty($_POST['birthday']) 
		) {
		//Пароль при регистрации должен совпадать с его повторным введением. Перестраховываем пользователя от случайной ошибки при вводе пароля 			
		if ($_POST['addPassword'] == $_POST['confirm']) {
			//Проверка, чтобы не было пустых строк
			if (
				!empty(trim($_POST['addLogin'])) AND !empty(trim($_POST['addPassword'])) AND !empty(trim($_POST['confirm'])) 
				AND !empty(trim($_POST['addEmail'])) AND !empty(trim($_POST['name'])) AND !empty(trim($_POST['surname']))
				AND !empty(trim($_POST['patronymic'])) AND !empty(trim($_POST['birthday']))
				) {
				$regLogin = "#^[A-Za-z\d]+$#";
				$regEmail = "#^[A-Za-z\d]+@[a-z]+\.[a-z]{2,}$#";
				//С помощью регулярки задаем создания логина только латинскими буквами, а так же цифрами
				if (preg_match($regLogin, $_POST['addLogin'])) {
					//Длина логина должна быть от 4 до 10 символов включительно
					if (strlen($_POST['addLogin']) >= 4 && strlen($_POST['addLogin']) <= 10) {
						//Длина пароля должна быть от 6 до 12 символов включительно
						if (strlen($_POST['addPassword']) >= 6 && strlen($_POST['addPassword']) <= 12) {
							//С помощью регулярки проверям, что электронный адрес указан корректно
							if (preg_match($regEmail, $_POST['addEmail'])) {
								$addLogin = $_POST['addLogin'];
								$addPassword = password_hash($_POST['addPassword'], PASSWORD_DEFAULT);
								$addEmail = $_POST['addEmail'];
								$name = $_POST['name'];
								$surname = $_POST['surname'];
								$patronymic = $_POST['patronymic'];
								$birthday = date($_POST['birthday']);
								$addCountry = $_POST['addCountry'];
								
								$query = "SELECT * FROM users WHERE login = '$addLogin'";
								$checkLogin = mysqli_query($connect, $query) or die (mysqli_error($connect));
								$user = mysqli_fetch_assoc($checkLogin);
							
								//Проверка на то, что логин не занятый, то есть пустой, в таком случае регистрируем нового пользователя
								if (empty($user)) {
									$date = date('Y-m-d');	
									$query = "INSERT INTO users SET login='$addLogin', password='$addPassword', email='$addEmail', 
											name='$name', surname='$surname', patronymic='$patronymic',
											birthday='$birthday', status='user', banned='0', country='$addCountry', registration_date='$date'";
									$result = mysqli_query($connect, $query) or die (mysqli_error($connect));	
								
									$_SESSION['auth'] = true;
									$_SESSION['login'] = $addLogin;
								
									$id = mysqli_insert_id($connect);
									$_SESSION['id'] = $id;
								
									header('Location: index.php');
								}
								else {
									$loginText = "<p style=\"color:red\"> username already exists </p>";
								}
							}
							else {
								$emailText = "<p style=\"color:red\"> enter the correct email </p>";
							}
						}
						else {
							$passwordText = "<p style=\"color:red\"> Your password must contain from 6 to 12 characters </p>";
						}
					}
					else {
						$loginText = "<p style=\"color:red\"> Your login must contain from 4 to 10 characters </p>";
					}
				}
				else {
					$loginText = "<p style=\"color:red\"> Login can contain only Latin letters or numbers </p>";
				}
			}
			else {
				$loginText = "<p style=\"color:red\"> Check all fields are full. Must not contain an empty string </p>";
			}
		}
		else {
			$passwordText = "<p style=\"color:red\"> enter the correct password </p>";
		}
	}
?>
<head>
	<meta charset="utf-8">
</head>
<form action="" method="POST">
	<p> Login: </p>
	<p> <?= $loginText; ?> </p>
	<input name="addLogin" value="<?php if(!empty($_POST['addLogin'])) echo $_POST['addLogin']; ?>">
	<p> Password: </p>
	<p> <?= $passwordText ?> </p>
	<input type="password" name="addPassword" value="<?php if(!empty($_POST['addPassword'])) echo $_POST['addPassword']; ?>">
	<p> Confirm password: </p>
	<p> </p>
	<input type="password" name="confirm" value="<?php if(!empty($_POST['confirm'])) echo $_POST['confirm']; ?>">
	<p> Email: </p>
	<p> <?= $emailText ?> </p>
	<input name="addEmail" value="<?php if(!empty($_POST['addEmail'])) echo $_POST['addEmail']; ?>">
	<p> Name: </p>
	<p> </p>
	<input name="name" value="<?php if(!empty($_POST['name'])) echo $_POST['name']; ?>">
	<p> Surname: </p>
	<p> </p>
	<input name="surname" value="<?php if(!empty($_POST['surname'])) echo $_POST['surname']; ?>">
	<p> Patronymic: </p>
	<p> </p>
	<input name="patronymic" value="<?php if(!empty($_POST['patronymic'])) echo $_POST['patronymic']; ?>">
	<p> Birthday (yyyy-mm-dd): </p>
	<p> </p>
	<input name="birthday" value="<?php if(!empty($_POST['birthday'])) echo $_POST['birthday']; ?>">
	<p> Country: </p>
	<p> </p>
	<select name="addCountry">
		<option> choose your country </option>
		<option> Sierra Leone  </option>
		<option> Grenada </option>
		<option> Botswana </option>
		<option> Somali </option>
	</select><br><br>
	<input type="submit" value="Register">
</form>