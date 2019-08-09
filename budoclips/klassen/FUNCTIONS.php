<?php

function MyDatabase() {
	$mysqli=new mysqli("localhost","web153","zivi8888","usr_web153_1");
	if (mysqli_connect_errno()) {
    	printf("Es konnte keine Verbindung zur Datenbank aufgebaut werden<p>", mysqli_connect_error());
    	exit();
	}
	return $mysqli;
}		

function zahl_de($zahl) {
	// Die Zahl wird vom Computerformat ins deutsche Format umgewandelt
	$zahl = floatval($zahl);
	$zahl = number_format($zahl,2,",",".");
	return $zahl;
}

function zahl_pc($zahl) {
	// Die Zahl wird vom deutschen Format ins PC-Format umgewandelt - 
	// Punkt in Nichts und Komma in Punkt
	$zahl=str_replace(".","",$zahl);
	$zahl=str_replace(",",".",$zahl);
	return $zahl;	
}


?>