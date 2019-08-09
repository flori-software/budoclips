-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Mrz 2019 um 21:15
-- Server-Version: 5.7.25
-- PHP-Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `usr_web153_1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Artikel`
--

CREATE TABLE `Artikel` (
  `ID` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `preis` double NOT NULL DEFAULT '0',
  `link_video` varchar(255) DEFAULT NULL,
  `link_vorschaubild` varchar(255) DEFAULT NULL,
  `link_video_hq` varchar(255) DEFAULT NULL,
  `speicher_normal` varchar(50) DEFAULT NULL,
  `speicher_best` varchar(50) DEFAULT NULL,
  `aktiv` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Artikel`
--

INSERT INTO `Artikel` (`ID`, `bezeichnung`, `preis`, `link_video`, `link_vorschaubild`, `link_video_hq`, `speicher_normal`, `speicher_best`, `aktiv`) VALUES
(1, 'Daito Ryu Aiki Ju Jutsu Lehrgang 2016', 20, 'video/DaitoRyu2016_XS.mp4', 'pics_artikel/DaitoRyu2016.png', 'video/DaitoRyu2016.png', '7,66 GB', '22,31 GB', 1),
(2, 'Daito Ryu Aiki Ju Jutsu Lehrgang 2018', 20, 'video/DaitoRyu2018XS.mp4', 'pics_artikel/DaitoRyu2018.png', 'video/DaitoRyu2018.png', '8,5 GB', '24,96 GB', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Benutzer`
--

CREATE TABLE `Benutzer` (
  `ID` int(11) NOT NULL,
  `benutzername` varchar(255) NOT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `ids_gekaufte_artikel` varchar(255) DEFAULT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `plz` varchar(255) DEFAULT NULL,
  `ort` varchar(255) DEFAULT NULL,
  `telefonnummer` varchar(255) DEFAULT NULL,
  `mobil` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Benutzer`
--

INSERT INTO `Benutzer` (`ID`, `benutzername`, `nachname`, `vorname`, `ids_gekaufte_artikel`, `strasse`, `plz`, `ort`, `telefonnummer`, `mobil`, `email`, `admin`, `passwort`) VALUES
(1, 'Arek', 'Arkadiusz', 'Paluszek', '1*2', 'Neustadter Str. 48', '96487', 'Dörfles-Esbach', '09561 6755137', '0176 642 755 72', 'arek@budoclips.de', 0, 'Florentina1'),
(3, 'Daishi', 'Nakajima', 'Michael Daishiro', '1*2', '', '', '', '', '', '', 1, 'test'),
(4, 'Duncan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'oldenburg'),
(5, 'Henry', NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, 0, 'test');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Artikel`
--
ALTER TABLE `Artikel`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `Benutzer`
--
ALTER TABLE `Benutzer`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Artikel`
--
ALTER TABLE `Artikel`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `Benutzer`
--
ALTER TABLE `Benutzer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
