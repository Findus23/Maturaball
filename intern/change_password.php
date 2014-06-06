<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">

		<title>Passwort ändern</title>
		<script language='javascript' type='text/javascript'>
			function check(input) { //Beim Abschicken wird überprüft ob die Passwörter übereinstimmen -- wenn nicht wird eine Meldung ausgegeben (funktioniert nur bei modernen Browsern) -> sonst per PHP
				if (input.value != document.getElementById('new_password1').value) {
					input.setCustomValidity('Die beiden Passwörter müssen übereinstimmen');
				} else {
					input.setCustomValidity('');
				}
}
</script>
	</head>

	<body>
		<h1>Passwort ändern</h1>

<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['user_id'])) {


if (isset($_POST["new_password1"]) && !empty($_POST["new_password1"]) && !empty($_POST["new_password2"])) {    //Wenn das Formular ausgefüllt wurde ...
	require_once "verbindungsaufbau.php";
	$new_password1 = $_POST["new_password1"];
	$new_password2 = $_POST["new_password2"];
	if ($new_password1 != $new_password2) { // überprüfen ob beide Passwörter übereinstimmen
		echo "<strong>Die beiden neuen Passwörter unterscheiden sich</strong>";
		exit();
	}
	$salt = getenv('WEBSITE_SALT');
	$salted_password = $salt . $new_password2; // und diesen an das Passwort anhängen ...
	$password_hash = hash('sha256', $salted_password); // ... und zuletzt das zusammengehängte Passwort mittels sha256 hashen
	if ($stmt = $mysqli->prepare("UPDATE benutzer SET password = ? WHERE user_id = ?")) {   // Der SQL-Befehl wird vorbereitet ...
		$stmt->bind_param("si", $password_hash, $_SESSION['user_id']);               // ... eingesetzt ...
		$stmt->execute();                                                               // ... und ausgeführt
		$stmt->close();
		$mysqli->close();
		echo "<p>Passwort wurde erfolgreich geändert!</p>";
	}
} else { 
?>
<form action="change_password.php" method="POST">
<table>
	<tr>
		<td>neues Passwort:</td>
		<td><input type="password" name="new_password1" id="new_password1" required /></td>
	</tr>
	<tr>
		<td>neues Passwort wiederholen:</td>
		<td><input type="password" name="new_password2" required oninput="check(this)" /></td>
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
