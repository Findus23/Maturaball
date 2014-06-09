<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<title>Reservierung abgesendet!</title>
</head>

<body>


<?php
if (isset($_POST["vorname"])) {
	if (!empty($_POST["vorname"]) && !empty($_POST["nachname"]) && !empty($_POST["telefon"]) && is_numeric($_POST["anzahl"])) {
		$vorname=$_POST["vorname"];
		$nachname=$_POST["nachname"];
		$telefon=$_POST["telefon"];
		$email=$_POST["email"];
		$anzahl=$_POST["anzahl"];
		$anmerkung=$_POST["anmerkung"];
		$zeit=date("Y-m-d H:i:s");
		if($email == "") { //Falls nichts eingetragen wurde null in die Datenbank schreiben
			$email = null;
		}
		if($anmerkung == "") {
			$anmerkung = null;
		}
		require_once 'funktionen.php';
		$inhalt="Es gibt eine neue Sitzplatzreservierung von " . $vorname . " " . $nachname . "!";
		email("maturaball@kremszeile.at", "Neue Sitzplatzreservierung", $inhalt, ""); //Benachrichtungs-Mail an Zuständige
		require_once "../intern/verbindungsaufbau.php";
		if ($stmt = $mysqli->prepare("INSERT INTO reservierungen (vorname,nachname,telefonnummer,email,anzahl,anmerkung,datum) VALUES (?, ?, ?, ?, ?, ?, ?)")) {   // Der SQL-Befehl wird vorbereitet ...
			$stmt->bind_param("ssssiss",$vorname,$nachname,$telefon,$email,$anzahl,$anmerkung,$zeit);               // ... eingesetzt ...
			if ($stmt->execute()) { // ... und ausgeführt
				echo "<p>Die Daten wurden erfolgreich gespeichert.</p>"; //wenn das Ausführen des MySQL-Befehl erfolgreich war - ausgeben
			} else {
				echo "<p><strong>Die Daten konnten nicht gespeichert werden. Folgender Fehler ist aufgetreten:" . $stmt->error . "</strong></p>"; // ansonsten Fehlermeldung ausgeben
			}
		} else {
			echo "<p><strong>Es trat ein Problem beim Speichern auf.</strong></p>"; //unwahrscheinlich -- Fehler beim Vorbereiten des Befehls
		}
		$inhalt="Inhalt der Bestätigungsmail";
		if (!empty($email)) { // Wenn eine E-Mail Adresse angegeben wurde, eine Bestätigungsmail verschicken
			email($email, "Bestätigung der Sitzplatzreservierung", $inhalt, "<p>Eine Bestätigungsemail wurde erfolgreich versandt.</p>");
		} else {
			echo "<p>Es wurde keine Bestätigungsemail verschickt, weil keine E-Mail angegeben wurde";
		}
		$stmt->close(); //Speicherplatz freigeben
		$mysqli->close();
		

		
	} else {
		echo "<p>Die Daten, die eingegeben wurden, sind ungültig. Entweder wurden Pflichtfelder frei gelassen oder bei der Platzanzahl keine Zahl eingegeben.</p><p><a href='javascript:history.back();'>Zurück zum Formular</a></p>";
	}
} else {
	echo "<p>Diese Seite kann nicht direkt aufgerufen werden.<p><p><strong>Bitte gehe <a href='../formular.html'>zum Formular</a>!</strong></p>";
}


?>

</body>
</html>
