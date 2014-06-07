<?php
require_once "../intern/verbindungsaufbau.php"; //mit SQL-Server verbinden

if (isset($_GET["id"]) && is_numeric($_GET["id"])) { // Wenn die id gültig ist ...
	$id = $_GET["id"];
	$query = "SELECT reserv_id, vorname, nachname, telefonnummer, email, anzahl, anmerkung, datum, bezahlt, bearbeiter, bearb_datum FROM reservierungen WHERE reserv_id=" . $id;
	if ($result = $mysqli->query($query)) { // Datenbank für e-Mail Backup auslesen 
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$backup=json_encode($row);
		$result->close();
		require_once 'funktionen.php';
		email("maturaball@kremszeile.at", "Backup", $backup, "");
		
	} else {
		echo "SQL-Fehler";
	}	
	if ($stmt = $mysqli->prepare("DELETE FROM reservierungen WHERE reserv_id = ?")) { // ... diese Veranstaltung löschen
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		header("Location: ".URL."/reservierungen.php"); // zur Hauptseite weiterleiten
	} else {
		echo "SQL-Fehler";
	}
} else {
	echo "unerlaubter id-Parameter";
}
?>