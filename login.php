<?php
session_start();
if (!isset($_SESSION["versuche"])) { //Wenn ein Neubesucher, dann Veruche auf 0 setzen
	$_SESSION["versuche"] = 0;
}
if ($_SESSION["versuche"] > 10) {
	echo "<p style='font-size:300%;'><strong>Du hast zu oft ein falsches Passwort eingegeben und wurdest daher gesperrt.<strong><p>";
	echo "<p style='font-size:150%;'>Um dich wieder neu anmelden zu k&ouml;nnen, musst du warten.<p>";
	
	exit;
}
if (isset($_GET["logout"])) { // um sich abzumelden an die url ?logout=true anhängen
	session_destroy();
	$logout=TRUE;
} else {
	$logout=FALSE;
}
if (isset($_POST["benutzername"]) && isset($_POST["passwort"])) { // wenn Benutzername eingegeben wurde
	require_once "verbindungsaufbau.php"; //mit Server verbinden
	$user= $_POST["benutzername"];
	$passwort= $_POST["passwort"];
	$salt = "*|!JeFF28S,@Z3Sm5\1?"; //  geheimer Zufallszeichenwert ...
	$salted_password = $salt . $passwort; // ... vor das Passwort hängen
	$password_hash = hash('sha256', $salted_password);
	if($stmt = $mysqli->prepare("SELECT password,user_id FROM benutzer WHERE name=?")) {
		$stmt->bind_param("s", $user);
		$stmt->execute();
		$stmt->bind_result($password_db, $user_id);
		$stmt->fetch();
		if($password_db == $password_hash) { // wenn die Anmeldung erfolgreich ist, werden Informationen über den aktuellen Benutzer in die Session geschrieben
			$_SESSION['user'] = $user;
			$_SESSION['user_id'] = $user_id;
		} else {
			echo "falsches Passwort";
			$_SESSION["versuche"] += 1;
		}
	} else {
		echo "falscher Benutzername";
		$_SESSION["versuche"] += 1;
		
	}
	$mysqli->close();
}
if (!isset($_SESSION['user']) || $logout == TRUE ) { // wenn noch nicht angemeldet
?>
<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="utf-8" />
	<title>Login</title>
	<meta name="author" content="Lukas Winkler" >
	<link rel="stylesheet" href="style.css" />
	<!-- hier schön designtes Anmeldeformular einfügen -->

</head>

<body>
<?php 
if ($logout == TRUE) {
	echo "<p><strong>Du hast dich erfolgreich abgemeldet</strong></p>";
}
?>
<form action="login.php" method="POST">
<table>
	<tr>
		<td>Benutzername:</td>
		<td><input type="text" name="benutzername" required autofocus /></td>
	</tr>
	<tr>
		<td>Passwort:</td>
		<td><input type="password" name="passwort" required /></td>
	</tr>
</table>
<input type="submit" value="anmelden" />
</form>



<?php
} else { //wenn man erfolgreich angemeldet wurde
echo "Hallo " . $_SESSION['user'] . " - <a href='./login.php?logout=yes'>Abmelden</a>";
echo "<script>window.opener.parent.location.reload();window.close();</script>"; // Das Fenster wird geschlossen und das Ursprungsfenster wird neu geladen
}
?>


</body>
</html>