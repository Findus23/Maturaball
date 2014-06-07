<?php
require_once "../intern/verbindungsaufbau.php"; //mit SQL-Server verbinden
session_start();

if (isset($_GET["id"]) && isset($_GET["bezahlt"]) && is_numeric($_GET["id"])) { // Wenn die id gültig ist ...
    $id = $_GET["id"];
	if ($_GET["bezahlt"] == "Ja") {
		$bezahlt="0";
	} elseif ($_GET["bezahlt"] == "Nein") {
		$bezahlt="1";
	} else {
		echo "<p>Ein Fehler ist aufgetreten</p>";
		exit;
	}
	$datum=date("Y-m-d H:i:s");
	$bearbeiter=$_SESSION['user_id'];
	if ($stmt = $mysqli->prepare("UPDATE reservierungen SET bezahlt = ?, bearbeiter = ?, bearb_datum = ? WHERE reserv_id = ?;")) { // ... diese Veranstaltung löschen
		$stmt->bind_param("iisi", $bezahlt, $bearbeiter, $datum, $id);
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