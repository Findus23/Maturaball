<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">

		<title>Passwort ändern</title>
	</head>

	<body>
		<h1>Passwort ändern</h1>

<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['user_id'])) {


if (isset($_POST["password"]) && !empty($_POST["password"])) {
	$password = $_POST["password"];    
	$salt = getenv('WEBSITE_SALT');
	$salted_password = $salt . $password;
	$password_hash = hash('sha256', $salted_password);

?>
<table>
	<tr>
		<td>Passwort:</td>
		<td><input type="text" value="<?php echo $password; ?>" readonly></td>
	</tr>
	<tr>
		<td>Hash:</td>
		<td><textarea readonly autofocus cols="64" style="resize: none"><?php echo $password_hash; ?></textarea></td>
	</tr>

</table>
STRG+A und STRG+C

<?php
} else { 
?>
<form action="password_helper.php" method="POST">
<table>
	<tr>
		<td>Passwort:</td>
		<td><input type="password" name="password" autofocus required /></td>
	</tr>
</table>
<input type="submit" value="Passwort ändern" />
</form>

<?php
}
} else {
	echo "<p>Du bist nicht angemeldet. Bitte <a href='login.php'>melde dich an</a>!</p>";
}

?>
	</body>
</html>
