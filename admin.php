<?php
	session_start();
	include 'connect.php';
	
	// удаляем пользователя
	$id = $_GET['deleteUser'];
	$queryDel = "DELETE FROM users WHERE id='$id'";
	$resultDel = mysqli_query($connect, $queryDel) or die (mysqli_error($connect)); 

	//меняем статус пользователю
	$statusId = $_GET['changeStatus'];
	$query = "SELECT * FROM users WHERE id='$statusId'";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	$row = mysqli_fetch_assoc($result);
	
	if ($row['status'] == 'admin') {
		$status = 'user';
	}
	else {
		$status = 'admin';
	}
	
	$queryStatus = "UPDATE users SET status='$status' WHERE id='$statusId'";
	$resultStatus = mysqli_query($connect, $queryStatus) or die (mysqli_error($connect));
	
	//баним пользователя
	$id_ban = $_GET['ban_id'];
	
	$queryBan = "UPDATE users SET banned='1' WHERE id='$id_ban'";
	$resultBan = mysqli_query($connect, $queryBan) or die (mysqli_error($connect));
	
	//разбаниваем пользователя
	$id_unban = $_GET['unban_id'];
	
	$queryUnban = "UPDATE users SET banned='0' WHERE id='$id_unban'";
	$resultUnban = mysqli_query($connect, $queryUnban) or die ($connect);
	
	//выводим в таблицу всех пользователей
	$query = "SELECT * FROM users";
	$result = mysqli_query($connect, $query) or die (mysqli_error($connect));
	for ($array = []; $row = mysqli_fetch_assoc($result); $array[] = $row);
?>
<head>
	<meta charset="utf-8">
</head>
	<table border=1 cellspacing=0>
		<tr>
			<th> Login </th>
			<th> Status </th>
			<th> Delete </th>
			<th> Сменить статус </th>
			<th> Забанить </th>
			<th> Разбанить </th>
			<th> Состояние пользователя </th>
		</tr>
<?php		
	foreach ($array as $allUsers) {
		if ($allUsers['status'] == 'admin') {
			$color = 'red';
			$statusСhange = 'Сделать его юзером';
		}
		else {
			$color = 'green';
			$statusСhange = 'Сделать его админом';
		}
		
		if ($allUsers['banned'] == '1') {
			$userState = 'забанен';
		}
		else {
			$userState = 'не забанен';
		}
		
		echo "<tr style=\"color:$color\">
				<td> {$allUsers['login']} </td>
				<td> {$allUsers['status']} </td>
				<td><a href=\"?deleteUser={$allUsers['id']}\"> Delete </a></td>
				<td><a href=\"?changeStatus={$allUsers['id']}\"> $statusСhange </a></td>
				<td><a href=\"?ban_id={$allUsers['id']}\"> Banned </a></td>
				<td><a href=\"?unban_id={$allUsers['id']}\"> Unbanned </a></td>
				<td> $userState </td>
			</tr>";
	}
?>
	</table>
	<br><br>
	<a href="index.php"> Вернуться на главную страницу	</a>
