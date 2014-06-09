<?php

function email($empfaenger,$betreff,$inhalt,$notiz) {
	$header  = "MIME-Version: 1.0" . "\n"; //Notwendig für HTML-E-Mail
	$header .= "Content-type: text/html; charset=iso-8859-1" . "\n"; // auch notwendig
 	$header .= "From: Sitzplatzreservierung <info@kremszeile.at>" . "\n"; //E-Mail-Adresse die als Absender angegeben wird
 	$header .= "Reply-To: maturaball@kremszeile.at>" . "\n"; // E-Mail-Adresse an die geantwortet wird
	$nachricht = "<html>
<head>
  <title>Sitzplatzreservierung</title>
</head>
<body>" . $inhalt . "</body>
</html>"; // Für E-Mail html<Grundgerüst hinzufügen
		if (mail($empfaenger, $betreff, $nachricht, $header)) { //E-Mail abschicken
 			echo $notiz;
		} else {
			echo "<p><strong>Leider konnte die E-Mail nicht verschickt werden.</strong></p>";
		}		
}
?>