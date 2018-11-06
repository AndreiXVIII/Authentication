<?php 
	session_start();
	if (!empty($_SESSION['auth'])) {
		$_SESSION['auth'] = true;
	}
	else {
		$_SESSION['auth'] = null;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Главная</title>
		<style>
		</style>
	</head>
	<body>
		<p> 
			Lorem ipsum amet sit magna sem ultricies gravida urna morbi amet. Adipiscing orci ornare orci at 
			enim sagittis ipsum integer sed metus ligula lectus, sed sagittis mattis malesuada non et magna. 
			Proin adipiscing sagittis, eget sapien congue eget ut diam amet leo amet. Quisque vitae nulla vitae 
			adipiscing sagittis eros morbi justo molestie sapien sit rutrum urna cursus lectus ornare elementum, 
			urna commodo. Sit donec lectus nec nibh urna adipiscing nibh curabitur ipsum porttitor, magna ligula duis 
			auctor malesuada auctor adipiscing sapien nulla. Et pellentesque amet malesuada elementum, massa elementum 
			ligula vivamus risus duis.
		</p>
		<br>
	<?php	
		if (!empty($_SESSION['auth'])) {
			echo "<p style=\"color:blue\"> 
					Enim maecenas tempus auctor, leo mauris at enim, sed morbi sed eget. Elementum ultricies mauris urna 
					vitae tempus molestie nec enim integer morbi, sem orci risus. Lectus pellentesque diam leo adipiscing 
					fusce malesuada maecenas massa eget ligula — sapien amet rutrum mauris, sodales eros quisque magna sem malesuada. 
					Porta odio sem pellentesque odio sodales, pharetra gravida tellus vitae diam, adipiscing odio commodo risus a maecenas 
					sapien, duis non elementum massa quam ligula. Curabitur non arcu tellus sagittis curabitur ipsum quam sodales enim: nec 
					molestie nec: justo sagittis vivamus ipsum elementum gravida nam sagittis bibendum non. Nam eu: auctor non odio, auctor 
					diam rutrum molestie ut pharetra amet ut, non ut sed justo eros morbi, nibh.
				 </p><br>";
			echo 'Вы зашли на сайт как '.$_SESSION['login'].'<br>';
			$personal = "<a href=\"personalArea.php\"> Личный кабинет </a>";
			$allUsers = "<a href=\"users.php\"> Просмотр всех пользоватлей </a>";
			$exit = "<a href=\"logout.php\"> Завершить текущую сессию </a>";
			
			if (!empty($_SESSION['auth']) && $_SESSION['status'] == 'admin') { ?>
				<a href="admin.php"> Админка </a><br>
	<?php	}
		}
		else {
			echo "<p><i> Авторизируйтесь, чтобы увидеть продолжение статьи... </i></p>
				  <a href=\"login.php\"> Авторизация </a>  &nbsp&nbsp&nbsp <a href=\"register.php\"> Регистрация </a>".'<br><br>';
		}
		echo $_SESSION['result'];
		unset($_SESSION['result']); 
	?>
	<br>
	<?= $personal; ?>
	<br><br>
	<?= $allUsers; ?>
	<br><br>
	<?= $exit; ?>
	</body>
</html>
