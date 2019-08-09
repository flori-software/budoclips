<?php
session_start();
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";
echo '<table boder="0" width="100%">
<tr><td valign="top">
Herzlich Willkommen!<p>
Auf dieser Seite findet Ihr eine &Uuml;bersicht der YouTube-Videos aus dem R&ouml;dentaler Dojo des Shinki Ryu Aiki Budo. Teilweise sind die Videos in rum&auml;nischer Sprache, da Sie f&uuml;r und mit den Mitgliedern der Aikido Shinki Rengo Gruppe aus Sibiu / Rum&auml;nien gemacht wurden. Viel Spa&szlig;!';
//<a href="mein_konto.php">Registrieren Sie sich</a>, um Zugang zu den hier erh&auml;ltlichen kostenpflichtigen Lehrvideos zu erhalten.</td><td>
	
if(isset($_SESSION["id_benutzer"])) {
	$member     = new Benutzer;
	$member->ID = $_SESSION["id_benutzer"];
}
else {
	echo '<form action="login.php" method="POST" class="login">
	<input name="benutzername" placeholder="Benutzername"><br>
	<input name="passwort" placeholder="Passwort" type="password"><br>
	<input type="submit" value="Einloggen">
	</form>';
}

echo '</td></tr>
</table><p>
Mehr &uuml;ber Aikido Shinki Rengo, Daitoryu Aiki Jujutsu und Itto-den Shinki Toho
erfahren Sie<a href="http://www.shinkirengo.de/de/"> hier</a>
<a href="http://www.shinkirengo.de/de/"><img src="pics/Aikido.png"></a>';
include "page_end.php";
?>