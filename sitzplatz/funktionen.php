<?php

function email($empfaenger,$betreff,$inhalt,$notiz) {
	$header  = "MIME-Version: 1.0" . "\r\n"; //Notwendig für HTML-E-Mail
	$header .= "Content-type: text/html; charset=utf-8" . "\r\n"; // auch notwendig
 	$header .= "From: Sitzplatzreservierung <info@kremszeile.at>" . "\r\n"; //E-Mail-Adresse die als Absender angegeben wird
 	$header .= "Reply-To: maturaball@kremszeile.at" . "\r\n"; // E-Mail-Adresse an die geantwortet wird
	$nachricht = "<html>
<head>
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