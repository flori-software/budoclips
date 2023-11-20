<?php
session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	</head>
	<link rel="stylesheet" type="text/css" href="beauty.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 	<link rel="stylesheet" href="/resources/demos/style.css">
	<body>
	<div class="mittelteil" id="mittelteil">
	<img src="pics/titelbild.JPG" class="titelbild">
<?php	
	$menu_inhalte = Array();
	$menu_inhalte[0]["name"] = "Home";
	$menu_inhalte[0]["link"] = "index.php";
	$menu_inhalte[1]["name"] = "Aikido";
	$menu_inhalte[1]["link"] = "aikido.php";
	$menu_inhalte[2]["name"] = "Daito-Ryu";
	$menu_inhalte[2]["link"] = "daito_ryu.php";
	$menu_inhalte[3]["name"] = "Ju Jutsu";
	$menu_inhalte[3]["link"] = "ju_jutsu.php";
	$menu_inhalte[4]["name"] = "Spiritualit&auml;t";
	$menu_inhalte[4]["link"] = "spirit.php";
	$menu_inhalte[5]["name"] = "Impressum";
	$menu_inhalte[5]["link"] = "impressum.php";
	if(isset($_SESSION["id_benutzer"])) {
		$menu_inhalte[6]["name"] = "Mein Konto";
		$menu_inhalte[6]["link"] = "mein_konto.php";
		$menu_inhalte[7]["name"] = "Ausloggen";
		$menu_inhalte[7]["link"] = "ausloggen.php";
	}

	foreach($menu_inhalte as $key=>$menupunkt) {
		echo '<a class="menu" href="'.$menupunkt["link"].'">'.$menupunkt["name"].'</a>';
	}
	echo '<p><div class="inhalt">';




?>