<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="../ressources/css/styleLogin.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="user" placeholder="Username" id="user" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
		</div>
	</body>
</html>

<?php  
session_start();

if (!isset($_POST['user'], $_POST['password'])){
exit();
}

$post = array(
    'username' => $_POST['user'],
    'password' => $_POST['password'],
	'Role' => "Admin"
);

$url = 'https://nihonsaba.net/TokenAPI/api/Login';

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json",
        'method'  => 'POST',
        'content' => json_encode($post),
        'timeout' => 60,
    ),
);
$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$oResponse = json_decode($response, true);

if(isset($oResponse["data"]["token"])){
    session_regenerate_id(); 
        $_SESSION['loggedin'] = TRUE; 
		$_SESSION['name'] = $oResponse["data"]["username"];
        $_SESSION['id'] = $oResponse["data"]["token"];
		if(!isset($_SESSION['return_uri'])){
			header('Location: ../pages/FileManagement/');
		} else {
			header('Location: '.$_SESSION['return_uri']);
		}   
} else {
 	echo($oResponse["message"]["Text"]);
}


?>