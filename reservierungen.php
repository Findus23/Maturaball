<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">

		<title>Reservierungen</title>
	</head>

	<body>
		<h1>Reservierungen</h1>

<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['user_id'])) {

require_once "verbindungsaufbau.php"; //mit Server verbinden
$ergebnis = $mysqli->query("SELECT reservierungen.reserv_id,vorname,nachname,telefonnummer,email,anzahl,datum,bezahlt,name FROM reservierungen,bearbeitungen,benutzer WHERE reservierungen.reserv_id = bearbeitungen.reserv_id AND bearbeitungen.user_id = benutzer.user_id");
echo "<table border='1'>\n";
echo "<tr><th>Vorname</th><th>Nachname</th><th>Telefon</th><th>E-Mail</th><th>Anzahl</th><th>Preis</th><th>Datum</th><th>Bezahlt</th><th>bearbeitet von</th>"; //Zeile mit Überschriften
while ($zeile = $ergebnis->fetch_array()) { // für jeden Wert in der Datenbank eine Tabellenzeile
		$preis=$zeile["anzahl"]*5;
		echo "<tr>\n<td>" . htmlspecialchars($zeile["vorname"]) . "</td>\n"
        . "<td>" . htmlspecialchars($zeile['nachname']) . "</td>\n"
        . "<td>" . htmlspecialchars($zeile['telefonnummer']) . "</td>\n"
        . "<td><a href='mailto:" . htmlspecialchars($zeile['email']) . "'>" . htmlspecialchars($zeile['email'])  . "</a></td>\n"
        . "<td>" . htmlspecialchars($zeile['anzahl']) . "</td>\n"
        . "<td>" . $preis . "€</td>\n"
        . "<td>" . htmlspecialchars($zeile['datum']) . "</td>\n"
        . "<td>" . htmlspecialchars($zeile['bezahlt']) . "</td>\n"
        . "<td>" . htmlspecialchars($zeile['name']) . "</td></tr>\n\n";
}
echo "</table>";
$ergebnis->close();
echo "<h2>Noch nicht bezahlt</h2>";
$ergebnis = $mysqli->query("SELECT reservierungen.reserv_id,vorname,nachname,telefonnummer,email,anzahl,datum FROM reservierungen,bearbeitungen WHERE reservierungen.reserv_id != bearbeitungen.reserv_id");
echo "<table border='1'>\n";
echo "<tr><th>Vorname</th><th>Nachname</th><th>Telefon</th><th>E-Mail</th><th>Anzahl</th><th>Preis</th><th>Datum</th>"; //Zeile mit Überschriften
while ($zeile = $ergebnis->fetch_array()) { // für jeden Wert in der Datenbank eine Tabellenzeile
		$preis=$zeile["anzahl"]*5;
		echo "<tr>\n<td>" . htmlspecialchars($zeile["vorname"]) . "</td>\n"
        . "<td>" . htmlspecialchars($zeile['nachname']) . "</td>\n"
        . "<td>" . htmlspecialchars($zeile['telefonnummer']) . "</td>\n"
        . "<td><a href='mailto:" . htmlspecialchars($zeile['email']) . "'>" . htmlspecialchars($zeile['email'])  . "</a></td>\n"
        . "<td>" . htmlspecialchars($zeile['anzahl']) . "</td>\n"
        . "<td>" . $preis . "€</td>\n"
        . "<td>" . htmlspecialchars($zeile['datum']) . "</td>\n"
		. "<td><a class='tabelle' href='./bezahlen.php?id=" . htmlspecialchars($zeile['reserv_id']) . "&bezahlt=yes'><b>teilnehmen</b></a></td></tr>\n\n";
		
}
echo "</table>";
$mysqli->close();


} else {
	echo "<p>Du bist nicht angemeldet. Bitte <a href='login.php'>melde dich an</a>!</p>";
}

?>
	</body>
</html>
