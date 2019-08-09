<?php
session_start();
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";

$member     = new Benutzer;
$member->ID = $_SESSION["id_benutzer"];
$member->get_benutzerdaten();

$artikel = new Artikel($_GET["id"]);

if(in_array($artikel->ID, $member->ids_gekaufte_artikel)) {
    echo '<p style="font-size: 24px;">'.$artikel->bezeichnung.'</p>
    <table><tr>
    <td>Download:</td>
    <td>
    <a href="'.$artikel->link_video.'" download>
    <div class="downloadbutton">Gute Qualit&auml;t - '.$artikel->speicher_normal.'
    </div></a></td>
    <td>
    <a href="'.$artikel->link_video_hq.'" download>
    <div class="downloadbutton">Sehr hohe Qualit&auml;t - '.$artikel->speicher_best.'
    </div></a></td>
    </tr></table>
    <video style="position: relative; width: 96%; left: 1%; top: 30px;" controls>
    <source src="'.$artikel->link_video.'" type="video/mp4">
    Your browser does not support the video tag.
    </video>';
}
else {
    // Zugriff wird verweigert
    echo '<span style="font-family: Helvetica; font-size: 36px; font-height: lighter;">
    Dieses Video haben Sie bisher nicht erworben.
    </span>';
}







?>