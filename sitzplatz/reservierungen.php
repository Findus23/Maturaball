<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">

		<title>Reservierungen</title>
		<style type="text/css">
			.Ja {
				background-color: #99FF99;
				display:block;
			}
			.Nein {
				background-color: #FF9999;
				display:block;
			}
			table {
				width:100%;
			}
			ul {
				list-style-type: none;
				text-align: center;
			}
			li {
				display: inline;
				margin-left: 20px;
				margin-right: 20px;
			}
			h1 {
				text-align: center;
			}
			.anmerkung {
				display: none;
			}
			@media print {
				nav, .delete {
					display: none;
				}
				h1 {
					font-size: 150%
				}
				.anmerkung {
					display:table-cell;
				}
			}
		</style>
		<script language="JavaScript">
			function check() {
				var wert = document.getElementById("anmerkung_check").checked;
				var zeilen = document.getElementsByClassName('anmerkung'), i;
				for (var i = 0; i < zeilen.length; i ++) {
					if(wert == false) {
						zeilen[i].style.display = 'none';
					} else {
						zeilen[i].style.display = 'table-cell'
					}
				}
			}
		</script>
	</head>

	<body>
		<h1>Reservierungen</h1>


<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['user_id'])) {
?>
<nav>
	<ul>
		<li>Hallo <?php echo $_SESSION["user"] ?></li>
		<li><a href="../intern/login.php?logout=yes">Abmelden</a></li>
		<li><a href="../intern/change_password.php">Passwort ändern</a></li>
		<li><a href='#' onclick="javascript:window.print();returnfalse">Drucken</a></li>
		<li><input type="checkbox" name="anmerkung_check" id="anmerkung_check" onchange="check();" > Anmerkungen anzeigen</li>
	</ul>
</nav>
<?php
require_once "../intern/verbindungsaufbau.php"; //mit Server verbinden
$ergebnis = $mysqli->query("SELECT reserv_id,vorname,nachname,telefonnummer,email,anzahl,datum,bezahlt,name,bearb_datum,anmerkung FROM reservierungen LEFT JOIN benutzer ON bearbeiter = user_id ORDER BY datum");
echo "<table border='1'>\n";
echo "<tr><th>Vorname</th><th>Nachname</th><th>Telefon</th><th>E-Mail</th><th>Anzahl</th><th>Preis</th><th class='anmerkung'>Anmerkung</th><th>Datum</th><th>Bezahlt</th><th>bearbeitet von</th><th>Datum</th><th class='delete'>löschen</th>"; //Zeile mit Überschriften
while ($zeile = $ergebnis->fetch_array()) { // für jeden Wert in der Datenbank eine Tabellenzeile
		$preis=$zeile["anzahl"]*5;
		if ($zeile["bezahlt"] == "1") {
			$bezahlt="Ja";
		} else {
			$bezahlt="Nein";
		}
		echo "<tr title='" . htmlspecialchars($zeile['anmerkung']) . "'>\n<td>" . htmlspecialchars($zeile["vorname"]) . "</td>\n"
		. "<td>" . htmlspecialchars($zeile['nachname']) . "</td>\n"
		. "<td>" . htmlspecialchars($zeile['telefonnummer']) . "</td>\n"
		. "<td><a href='mailto:" . htmlspecialchars($zeile['email']) . "'>" . htmlspecialchars($zeile['email'])  . "</a></td>\n"
		. "<td>" . htmlspecialchars($zeile['anzahl']) . "</td>\n"
		. "<td>" . $preis . "€</td>\n"
		. "<td class='anmerkung'>" . htmlspecialchars($zeile['anmerkung']) . "</td>\n"
		. "<td>" . htmlspecialchars($zeile['datum']) . "</td>\n"
		. "<td class='" . $bezahlt . "'><a href='./bezahlen.php?id=" . htmlspecialchars($zeile['reserv_id']) . "&bezahlt=" . $bezahlt . "'><b>" . $bezahlt . "</b></a></td>\n"
		. "<td>" . htmlspecialchars($zeile['name']) . "</td>\n"
		. "<td>" . htmlspecialchars($zeile['bearb_datum']) . "</td>\n"
		. "<td class='delete'><a href='./delete.php?id=" . htmlspecialchars($zeile['reserv_id']) . "'><b>Löschen</b></a></td>\n</tr>\n\n";
		
}
$ergebnis->close();
$mysqli->close();


} else {
	echo "<p>Du bist nicht angemeldet. Bitte <a href='../intern/login.php'>melde dich an</a>!</p>";
}

?>
	</body>
</html>
