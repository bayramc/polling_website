<html lang="EN">

<head>
	<link rel="stylesheet" href="styles.css">
	<title>Login Page</title>
</head>

<body>
	<h1>Welcome to the login page!</h1>
	<form method="post">
		<label for="name">Username:</label><br>
		<input type="text" id="name" name="name"><br>
		<label for="password">Password:</label><br>
		<input type="password" id="password" name="password"><br><br>
		<span id="wrong-pass" class="error"></span>
		<input type="submit" value="Log In">
	</form>
	<br>
	<form action="reg.php">
		<input type="submit" value="Register">
	</form>
</body>

</html>
<?php
session_start();

$_SESSION["loggedin"] = false;

if (isset($_POST["name"]) && isset($_POST["password"])) {
	$valid_user = true;
	$name = $_POST["name"];
	$password = $_POST["password"];

	// Read the JSON file
	$data = json_decode(file_get_contents('users.json'), true);

	// Search for the user in the JSON file
	foreach ($data['users'] as $user) {
		if ($user["username"] == $name && $user["password"] == $password && $user["isAdmin"] == true) {
			$_SESSION["loggedin"] = true;
			$_SESSION["username"] = $name;
			$_SESSION["isAdmin"] = $user["isAdmin"];
			session_write_close();
			header("Location: adminindex.php");
			$valid_user = true;

		} else if ($user["username"] == $name && $user["password"] == $password){
			$_SESSION["loggedin"] = true;
			$_SESSION["username"] = $name;
			session_write_close();

			header("Location: index.php");
			$valid_user = true;

		}
		else {
			$valid_user = false;
			echo "<script>document.getElementById('wrong-pass').innerHTML = 'Invalid username or password';</script>";
		}

	}

	
}

?>