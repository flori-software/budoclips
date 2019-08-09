<?php

class Kontaktdaten {
	public $strasse;
	public $plz;
	public $ort;
	
	public $telefonnummer;
	public $mobil;
	public $email;

}

class Benutzer {
	public $ID;
	public $vorname;
	public $nachname;
	public $benutzername;
	public $kontakt; // Eigenständige Klasse
	public $ids_gekaufte_artikel; // Array
	public $admin;
	public $passwort;

	public function __construct() {
		$this->ids_gekaufte_artikel = Array();
		$this->kontakt = new Kontaktdaten;
	}

	public static function neuen_speichern($benutzername, $passwort) {
		$mysqli   = MyDatabase();
		$eintrag  = "INSERT INTO `Benutzer` (`benutzername`, `passwort`) VALUES ('".$benutzername."', '".$passwort."')";
		if($mysqli->query($eintrag)) {
			echo "Neuer Benutzer gespeichert.<p>";
		}
		else {
			echo "Fehler beim Speichern des neuen Benutzers, siehe SQL_Befehl: <br>".$eintrag."<p>";
		}
	}
	
	public function formular_benutzerdaten_lesen() {
		$this->vorname					= $_POST["vorname"];
		$this->nachname					= $_POST["nachname"];
		$this->benutzername				= $_POST["benutzername"];
		$this->kontakt->strasse			= $_POST["strasse"];
		$this->kontakt->plz				= $_POST["plz"];
		$this->kontakt->ort 			= $_POST["ort"];
		$this->kontakt->telefonnummer	= $_POST["telefonnummer"];
		$this->kontakt->mobil 			= $_POST["mobil"];
		$this->kontakt->email			= $_POST["email"];
		if(isset($_POST["admin"])) {
			$this->admin				= $_POST["admin"];
		}
		else {
			$this->admin				= 0;
		}
		// Evtl. Anpassung des Passworts
		$passwort 						= $_POST["passwort"];
		$passwort2 						= $_POST["passwort2"];
		if($passwort != "" && $passwort === $passwort2) {
			$this->passwort = $passwort;
		}
		else {
			$this->passwort = "";
		}
		$this->daten_bearbeiten();
	}

	private function daten_bearbeiten() {
		$mysqli  = MyDatabase();
		$eintrag = "UPDATE `Benutzer` Set
		`benutzername` = '".$this->benutzername."',
		`nachname` = '".$this->nachname."',
		`vorname` = '".$this->vorname."',
		`strasse` = '".$this->kontakt->strasse."',
		`plz` = '".$this->kontakt->plz."',
		`ort` = '".$this->kontakt->ort."',
		`telefonnummer` = '".$this->kontakt->telefonnummer."',
		`mobil` = '".$this->kontakt->mobil."',
		`email` = '".$this->kontakt->email."',
		`admin` = '".$this->admin."'";
		if($this->passwort != "") {$eintrag .= ", `passwort` = '".$this->passwort."'";}
		$eintrag .= "WHERE `ID` = '".$this->ID."'";
		
		if($mysqli->query($eintrag)) {
			echo "Daten ver&auml;ndert<p>";
		}
		else {
			echo "Fehler beim Speichern der Daten: $eintrag";
		}
	}

	public function login($benutzername, $passwort) {
		$test = 0;
		$mysqli = MyDatabase();
		$abfrage = "SELECT * FROM `Benutzer`";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				if($row->benutzername == $benutzername && $row->passwort == $passwort) {
					$_SESSION["id_benutzer"] = $row->ID;
					$test = 1;
					// Ist der Benutzer auch Administrator?
					$_SESSION["admin"] = $row->admin;
				}
			}
		}
		else {
			echo "Es konnten keine Beutzer aus der Datenbank gelesen werden<p>";
		}
		if($test == 0) {echo "<p>Benutzername oder Passwort falsch.<br>";}
	}

	public function logout() {
		session_destroy();
	}

	public function get_benutzerdaten() {
		$mysqli = MyDatabase();
		$abfrage = "SELECT * FROM `Benutzer` WHERE `ID`='".$this->ID."'";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				$this->vorname			= $row->vorname;
				$this->nachname			= $row->nachname;
				$this->benutzername		= $row->benutzername;
				$gekaufte_artikel		= $row->ids_gekaufte_artikel;
				$this->ids_gekaufte_artikel = explode("*", $gekaufte_artikel);
				$this->admin			= $row->admin;
				$this->kontakt->strasse	= $row->strasse;
				$this->kontakt->plz		= $row->plz;
				$this->kontakt->ort		= $row->ort;
				
				$this->kontakt->telefonnummer = $row->telefonnummer;
				$this->kontakt->mobil	= $row->mobil;
				$this->kontakt->email	= $row->email;
			}
		}
	}

	public function filme_speichern($filme) {
		$this->ids_gekaufte_artikel = Array();
		echo "Filme hat ".count($filme)." Elemente<br>";
		foreach ($filme as $key => $film) {
			if($film == 1) {$this->ids_gekaufte_artikel[] = $key;}
		}
		print_r($ids);
		$ids_gekaufte_artikel = implode("*", $this->ids_gekaufte_artikel);
		$mysqli = MyDatabase();
		$eintrag = "UPDATE `Benutzer` Set `ids_gekaufte_artikel`='".$ids_gekaufte_artikel."' WHERE `ID` = '".$this->ID."'";
		if($mysqli->query($eintrag)) {
			echo 'Gekaufte Artikel gespeichert<br>';
		}
		else {
			echo 'Fehler beim Speichern der gekauften Artikel<br>';
		}
	}

	public static function namen_aller_benutzer() {
		$alle_benutzer = Array();
		$mysqli = MyDatabase();
		$abfrage = "SELECT * FROM `Benutzer` ORDER BY `benutzername` ASC";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				$benutzer     			= new Benutzer;
				$benutzer->ID 			= $row->ID;
				$benutzer->benutzername = $row->benutzername;
				$alle_benutzer[] = $benutzer;
			}
		}
		return $alle_benutzer;
	}
}

class Artikel {
	public $ID;
	public $bezeichnung;
	public $preis;
	public $link_video;
	public $link_vorschaubild;
	public $link_video_hq;
	public $speicher_normal;
	public $speicher_best;
	public $aktiv;

	// Nur in Verbindung mit einem Benutzer:
	public $gekauft;

	public function __construct($id) {
		$this->ID = $id;
		// Lesen der Artikeldaten
		$mysqli  = MyDatabase();
		$abfrage = "SELECT * FROM `Artikel` WHERE `ID`='".$this->ID."'"; 
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				$this->bezeichnung 			= $row->bezeichnung;
				$this->preis 				= zahl_de($row->preis);
				$this->link_video 			= $row->link_video;
				$this->link_vorschaubild 	= $row->link_vorschaubild;
				$this->link_video_hq 		= $row->link_video_hq;
				$this->speicher_normal		= $row->speicher_normal;
				$this->speicher_best        = $row->speicher_best;
				$this->aktiv 				= $row->aktiv;
			}
		}

		// Feststellen, ob der Artikel vom eingeloggten Benutzer gekauft wurde
		if(isset($_SESSION["id_benutzer"])) {
			$Benutzer = new Benutzer;
			$Benutzer->get_benutzerdaten();
			if(in_array($this->ID, $Benutzer->ids_gekaufte_artikel)) {
				$gekauft = 1;
			}
			else {
				$gekauft = 0;
			}
		}
		else {
			$this->gekauft = 0; // Wenn niemand eingeloggt ist, sind die Artikel auch nicht "gekauft"
		}
	}

	public static function get_alle_Artikel() {
		$mysqli = MyDatabase();
		$alle_Artikel = Array();
		$abfrage = "SELECT * FROM `Artikel`";
		if($result = $mysqli->query($abfrage)) {
			while($row = $result->fetch_object()) {
				$id = $row->ID;
				$artikel 		= new Artikel($id);
				$alle_Artikel[] = $artikel;
			}
		}
		return $alle_Artikel;
	}
}
?>