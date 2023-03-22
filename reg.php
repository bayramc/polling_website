<html>

<html>
<head>
	<link rel="stylesheet" href="styles.css">
	<title>Registration Page</title>
</head>
<body>
	<h1>Welcome to the registration page</h1>
	<form action="" method="post">
		<label for="name">Username:</label><br>
		<input type="text" id="name" name="name"><br>
		<label for="password">Password:</label><br>
		<input type="password" id="password" name="password"><br>
		<label for="password_repeat">Repeat Password:</label><br>
		<input type="password" id="password_repeat" name="password_repeat"><br>
		<label for="email">Email:</label><br>
		<input type="email" id="email" name="email"><br><br>
		<input type="submit" value="Register">
	</form>
	<br>
	<form action="login.php">
		<input type="submit" value="Log In">
	</form>
</body>
</body>
</html>

<?php

if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["password_repeat"]) && isset($_POST["email"])) {
	if ($_POST["password"] != $_POST["password_repeat"]) {
		echo '<script>alert("Password is not the same please try again!")</script>';
    } else {
	$name = $_POST["name"];
	$password = $_POST["password"];
	$email = $_POST["email"];

	// Read the JSON file
	$data = json_decode(file_get_contents('users.json'), true);

	// Add the new user to the JSON file
	$data["users"][] = array("id" => uniqid(), "username" => $name, "password" => $password, "email" => $email, "isAdmin" => false);

	// Save the JSON file
	file_put_contents('users.json', json_encode($data));

	header("Location: login.php");
	}
}
?>