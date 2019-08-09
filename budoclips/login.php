<?php
session_start();

header("refresh:0;url=index.php");

include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";

$benutzername = $_POST["benutzername"];
$passwort     = $_POST["passwort"];

$benutzer = new Benutzer;
$benutzer->login($benutzername, $passwort);

echo "Eingeloggt ".$_SESSION["id_benutzer"];
?>