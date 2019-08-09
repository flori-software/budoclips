<?php
session_start();
include "page_start.php";
include "klassen/FUNCTIONS.php";
include "klassen/klasse_personen.php";

$member = new Benutzer;
if(isset($_GET["id"])) {
    $member->ID = $_GET["id"];
}
else {
    $member->ID = $_SESSION["id_benutzer"];
}
$member->get_benutzerdaten();

if(isset($_GET["aktion"])) {
    $aktion = $_GET["aktion"];
}
else {
    $aktion = 0;
}

if($aktion === "bearbeiten") {
    $member->formular_benutzerdaten_lesen();
}

if($aktion === "neuer_benutzer") {
    $benutzername = $_POST["benutzername"];
    $passwort     = $_POST["passwort"];
    $passwort2    = $_POST["passwort2"];
    if($benutzername != "" && $passwort == $passwort2) {
        Benutzer::neuen_speichern($benutzername, $passwort);
    }
    elseif($benutzername == "") {
        echo "Es muss ein Benutzername eingegeben werden, um einen neuen Benutzer zu speichern.<p>";
    }
    else {
        echo "Die eingegebenen Passw&ouml;rter waren nicht identisch.<p>";
    }
}

if($aktion === "benutzerdaten_zeigen") {
    // Die oeben gelesenen Daten des eingeloggten Benutzers werden jetzt mit den Daten des ausgewählten Benutzers überschrieben
    $member->get_benutzerdaten();
}

if($aktion === "filme_speichern") {
    $alle_Artikel = Artikel::get_alle_Artikel();
    $filme = Array();
    foreach($alle_Artikel as $artikel) {
        $filme[$artikel->ID] = $_POST["artikel".$artikel->ID];
    }
    $member->filme_speichern($filme);
}
echo '<form action="mein_konto.php?aktion=bearbeiten&id='.$member->ID.'" method="POST">';

echo '<input name="benutzername" id="benutzername" placeholder="Benutzername / username" value="'.$member->benutzername.'" style="width: 70%; background-color: '.$input_hintergrundfarbe.';"><br>
<input name="vorname" id="vorname" placeholder="Vorname / First name" value="'.$member->vorname.'" style="width: 28%; background-color: '.$input_hintergrundfarbe.';">&nbsp;
<input name="nachname" id="nachname" placeholder="Nachname" value="'.$member->nachname.'" style="width: 28%; background-color: '.$input_hintergrundfarbe.';"><br>
<input name="strasse" id="strasse" placeholder="Strasse / Street" style="width: 70%; background-color: '.$input_hintergrundfarbe.';" value="'.$member->kontakt->strasse.'"><br>
<input name="plz" id="plz" placeholder="PLZ / ZIP" style="width: 15%; background-color: '.$input_hintergrundfarbe.';" value="'.$member->kontakt->plz.'">&nbsp;
<input name="ort" id="ort" placeholder="Ort / Location" style="width: 53%; background-color: '.$input_hintergrundfarbe.';" value="'.$member->kontakt->ort.'"><br>';

echo '<input type="tel" name="telefonnummer" placeholder="Telefon / Phone" value="'.$member->kontakt->telefonnummer.'" style="width: 34%;">&nbsp;
<input type="tel" name="mobil" placeholder="Handy / mobile" value="'.$member->kontakt->mobil.'" style="width: 34%;">&nbsp;
<input type="email" name="email" id="email" placeholder="Email" value="'.$member->kontakt->email.'" style="width: 34%; background-color: '.$input_hintergrundfarbe.';"><br>
<input type="password" name="passwort" id="passwort" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="Passwort / password">&nbsp;
<input type="password" name="passwort2" id="passwort2" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="repeat password"><br>';
if($_SESSION["admin"] == 1) {
    echo '<input type="checkbox" style="padding: 5px; border-radius: 2px; width: 20px;" name="admin" value="1" ';
    if($member->admin == 1) {echo " checked";}
    echo '> <span style="font-size: 20px; font-weight: lighter;">Admin</span><br>';
}
echo '<input style="background-color: moccasin;" type="submit" value="Daten &auml;ndern" id="speichern"></form>';	

echo '<hr>
<p style="font-size: 20px; font-weight: lighter;">Gekaufte Artikel:</p>';
$alle_Artikel = Artikel::get_alle_Artikel();
echo '<table border="0">
<form action="mein_konto.php?aktion=filme_speichern&id='.$member->ID.'" method="post"><tr>';
foreach($alle_Artikel as $artikel) {
    echo '<td>';
    if(in_array($artikel->ID, $member->ids_gekaufte_artikel)) {
        echo '<a href="video.php?id='.$artikel->ID.'">';
    }
    echo '<img src="';
    if(!in_array($artikel->ID, $member->ids_gekaufte_artikel)) {echo 'sw';}
    echo $artikel->link_vorschaubild.'" height="200" style="border-radius: 20px;';
    if(!in_array($artikel->ID, $member->ids_gekaufte_artikel)) {echo 'opacity: 0.3;';}
    echo '">';
    if(in_array($artikel->ID, $member->ids_gekaufte_artikel)) {
        echo '</a>';
    }
    echo '<br>
    '.$artikel->bezeichnung.'<br>
    Preis: '.zahl_de($artikel->preis).' &euro;<br>';
    if($_SESSION["admin"] == 1) {
        echo 'Gekauft: <input type="checkbox" name="artikel'.$artikel->ID.'" value="1" ';
        if(in_array($artikel->ID, $member->ids_gekaufte_artikel)) {
            echo "checked";
        }
        echo '> </td>';
    }
    // PAYPAL BUTTON
    if(!in_array($artikel->ID, $member->ids_gekaufte_artikel)) {
        /*echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="DADZNECM2LDC2">
            <input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
            <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
            </form>';*/
    }
}
echo '</tr>';
if($_SESSION["admin"] == 1) {
    echo '<tr><td colspan="3"><input style="background-color: moccasin;" type="submit" value="Gekaufte Artikel speichern" id="speichern"></td></tr>';
}
echo '</form>';
// ADMINISTRATORBEREICH
if($_SESSION["admin"] == 1) {
    echo '</table>';
    echo '<hr><form action="mein_konto.php?aktion=neuer_benutzer" method="POST">
    <span style="font-size: 20px; font-weight: lighter;">Neuer Benutzer:</span><br>
    <input name="benutzername" id="benutzername" placeholder="Benutzername / username" style="width: 70%; background-color: '.$input_hintergrundfarbe.';"><br>
    <input type="password" name="passwort" id="passwort" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="Passwort / password">&nbsp;
    <input type="password" name="passwort2" id="passwort2" style="width: 34%; background-color: '.$input_hintergrundfarbe.';" placeholder="repeat password"><br>
    <input style="background-color: moccasin;" type="submit" value="Neuen Benutzer Speichern" id="speichern"></form>
    <hr>
    <span style="font-size: 20px; font-weight: lighter;">Registrierte Benutzer:</span><br>';
    $members = Benutzer::namen_aller_benutzer();
    $gezeigte_mitglieder = 0;
    echo '<table border="0">';
    foreach ($members as $member) {
        if($gezeigte_mitglieder == 0) {echo '<tr>';}
        echo '<td><div style="background-color: firebrick; color: white; height: 20px; border-radius: 10px; padding: 5px; width: auto; whitespace: nowrap;" onclick="benutzerdaten_zeigen('.$member->ID.')">'.$member->benutzername.'</div></td>';
        $gezeigte_mitglieder++;
        if($gezeigte_mitglieder == 8) {
            echo '</tr>';
            $gezeigte_mitglieder = 0;
        }
    }
    
}
echo '</table>';
include "page_end.php";

?>
<script>
function benutzerdaten_zeigen(id) {
    window.location.href = "mein_konto.php?aktion=benutzerdaten_zeigen&id=" + id;
}
</script>