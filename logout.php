<?php
	session_start();
	$_SESSION['auth'] = null;
	$_SESSION['result'] = 'Пользователь '.$_SESSION['login'].' перестал быть активным';
	$_SESION['id'] = null;
	$_SESSION['status'] = null;
	header('Location: index.php');
	
	//При попадании в данный файл, указанные сессии сбрасываются, после чего происходит редирект на главную страницу
?>
	