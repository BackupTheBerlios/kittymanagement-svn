-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 26. Januar 2011 um 13:14
-- Server Version: 5.1.41
-- PHP-Version: 5.3.3



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `kaffeekasse`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kaffee_kasse`
--

DROP TABLE IF EXISTS `kaffee_kasse`;
CREATE TABLE IF NOT EXISTS `kaffee_kasse` (
  `lfdnr` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `betrag` decimal(10,2) NOT NULL,
  `art` varchar(45) NOT NULL,
  `bemerkung` varchar(120) NOT NULL,
  PRIMARY KEY (`lfdnr`)
) TYPE=MyISAM  AUTO_INCREMENT=11 ;

--
-- Daten für Tabelle `kaffee_kasse`
--

INSERT INTO `kaffee_kasse` (`lfdnr`, `datum`, `betrag`, `art`, `bemerkung`) VALUES
(1, '2010-12-31', '-77.07', '-', 'Übertrag altes Kassenbuch'),
(2, '2011-01-17', '-10.00', '-', 'Bareinzahlung - Monatsbeitrag'),
(3, '2011-01-17', '-5.00', '-', 'Bareinzahlung - Monatsbeitrag'),
(4, '2011-01-17', '-5.00', '-', 'Bareinzahlung - Monatsbeitrag'),
(5, '2011-01-17', '-10.00', '-', 'Bareinzahlung - Monatsbeitrag'),
(6, '2011-01-18', '-4.00', '-', 'Bareinzahlung - Monatsbeitrag'),
(7, '2011-01-19', '6.00', '+', 'Einkauf - Milch'),
(8, '2011-01-19', '-6.00', '-', 'Bareinzahlung - Sonstiges'),
(9, '2011-01-19', '12.00', '-', 'Barauszahlung - Guthaben'),
(10, '2011-01-19', '-4.81', '-', 'Spende an Kaffeekasse');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kaffee_verbrauch`
--

DROP TABLE IF EXISTS `kaffee_verbrauch`;
CREATE TABLE IF NOT EXISTS `kaffee_verbrauch` (
  `lfdnr` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datum` date DEFAULT NULL,
  `zaehlerstand` int(11) DEFAULT NULL,
  `menge` decimal(10,5) DEFAULT NULL,
  `marke` varchar(45) DEFAULT NULL,
  `tassen_tag` decimal(10,5) DEFAULT NULL,
  `tassen_kg` decimal(10,5) DEFAULT NULL,
  `tage_kg` decimal(10,5) DEFAULT NULL,
  PRIMARY KEY (`lfdnr`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `kaffee_verbrauch`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lager_artikel`
--

DROP TABLE IF EXISTS `lager_artikel`;
CREATE TABLE IF NOT EXISTS `lager_artikel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sorte` varchar(150) NOT NULL,
  `uom` varchar(20) NOT NULL,
  `uom_short` varchar(10) NOT NULL,
  `size` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `lager_artikel`
--

INSERT INTO `lager_artikel` (`id`, `sorte`, `uom`, `uom_short`, `size`) VALUES
(1, 'H-Milch 3,5%', 'Liter', 'L', '1.00'),
(2, 'Wiener Kaffee Minas', 'Kilogramm', 'kg', '1.00'),
(3, 'Tchibo Espresso Gusto Originale', 'Kilogramm', 'kg', '1.00'),
(4, 'Lavazza Grande Ristorazione', 'Kilogramm', 'kg', '1.00'),
(5, 'Cafeclub Crema Schümli', 'Kilogramm', 'kg', '1.00'),
(6, 'Lazarro Crema Schümli', 'Kilogramm', 'kg', '1.00'),
(7, 'Lazarro Espresso', 'Kilogramm', 'kg', '1.00'),
(8, 'H-Milch 1,5%', 'Liter', 'L', '1.00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lager_ausgang`
--

DROP TABLE IF EXISTS `lager_ausgang`;
CREATE TABLE IF NOT EXISTS `lager_ausgang` (
  `lfdnr` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL,
  `anzahl` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`lfdnr`),
  KEY `eid` (`eid`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `lager_ausgang`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lager_eingang`
--

DROP TABLE IF EXISTS `lager_eingang`;
CREATE TABLE IF NOT EXISTS `lager_eingang` (
  `lfdnr` int(11) NOT NULL AUTO_INCREMENT,
  `art_id` int(11) NOT NULL,
  `anzahl` int(11) NOT NULL,
  `preis_pro_stueck` decimal(10,5) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`lfdnr`),
  KEY `sid` (`art_id`)
) TYPE=MyISAM  AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `lager_eingang`
--

INSERT INTO `lager_eingang` (`lfdnr`, `art_id`, `anzahl`, `preis_pro_stueck`, `datum`) VALUES
(1, 2, 9, '3.29000', '2010-12-31'),
(2, 3, 5, '5.49000', '2010-12-31'),
(3, 4, 2, '6.95000', '2010-12-31'),
(4, 5, 1, '5.99000', '2010-12-31'),
(5, 6, 1, '5.99000', '2010-12-31'),
(6, 7, 1, '5.99000', '2010-12-31'),
(7, 8, 12, '0.50000', '2011-01-13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `maschine_tassen`
--

DROP TABLE IF EXISTS `maschine_tassen`;
CREATE TABLE IF NOT EXISTS `maschine_tassen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zaehlerstand` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `maschine_tassen`
--

INSERT INTO `maschine_tassen` (`id`, `zaehlerstand`, `datum`) VALUES
(1, 7935, '2010-12-22');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitglieder_konto`
--

DROP TABLE IF EXISTS `mitglieder_konto`;
CREATE TABLE IF NOT EXISTS `mitglieder_konto` (
  `lfdnr` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kk_lfdnr` int(11) NOT NULL,
  `ma_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `betrag` decimal(10,2) NOT NULL,
  `art` varchar(45) NOT NULL,
  `bemerkung` varchar(120) NOT NULL,
  PRIMARY KEY (`lfdnr`),
  KEY `ma_index` (`ma_id`),
  KEY `fk_ma_konto_mitglieder` (`ma_id`),
  KEY `fk_ma_konto_kaffee_kasse` (`lfdnr`)
) TYPE=MyISAM  AUTO_INCREMENT=42 ;

--
-- Daten für Tabelle `mitglieder_konto`
--

INSERT INTO `mitglieder_konto` (`lfdnr`, `kk_lfdnr`, `ma_id`, `datum`, `betrag`, `art`, `bemerkung`) VALUES
(1, 0, 1, '2010-12-31', '6.00', '+', 'Übertrag altes Kassenbuch'),
(2, 0, 2, '2010-12-31', '3.03', '+', 'Übertrag altes Kassenbuch'),
(3, 0, 3, '2010-12-31', '6.75', '+', 'Übertrag altes Kassenbuch'),
(4, 0, 4, '2010-12-31', '0.50', '+', 'Übertrag altes Kassenbuch'),
(5, 0, 5, '2010-12-31', '0.00', '+', 'Übertrag altes Kassenbuch'),
(6, 0, 6, '2010-12-31', '-2.00', '-', 'Übertrag altes Kassenbuch'),
(7, 0, 7, '2010-12-31', '2.00', '+', 'Übertrag altes Kassenbuch'),
(8, 0, 8, '2010-12-31', '0.00', '+', 'Übertrag altes Kassenbuch'),
(9, 0, 9, '2010-12-31', '3.00', '+', 'Übertrag altes Kassenbuch'),
(10, 0, 10, '2010-12-31', '19.76', '+', 'Übertrag altes Kassenbuch'),
(11, 0, 11, '2010-12-31', '0.50', '+', 'Übertrag altes Kassenbuch'),
(12, 0, 12, '2010-12-31', '0.00', '+', 'Übertrag altes Kassenbuch'),
(13, 0, 13, '2010-12-31', '13.22', '+', 'Übertrag altes Kassenbuch'),
(14, 0, 14, '2010-12-31', '14.81', '+', 'Übertrag altes Kassenbuch'),
(15, 0, 15, '2010-12-31', '3.00', '+', 'Übertrag altes Kassenbuch'),
(16, 0, 16, '2010-12-31', '1.43', '+', 'Übertrag altes Kassenbuch'),
(17, 0, 17, '2010-12-31', '8.00', '+', 'Übertrag altes Kassenbuch'),
(18, 0, 1, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(19, 0, 2, '2011-01-01', '-2.00', '-', 'Monatsbeitrag - Januar 2011'),
(20, 0, 3, '2011-01-01', '-2.00', '-', 'Monatsbeitrag - Januar 2011'),
(21, 0, 4, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(22, 0, 6, '2011-01-01', '-2.00', '-', 'Monatsbeitrag - Januar 2011'),
(23, 0, 7, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(24, 0, 8, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(25, 0, 9, '2011-01-01', '-2.00', '-', 'Monatsbeitrag - Januar 2011'),
(26, 0, 10, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(27, 0, 11, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(28, 0, 12, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(29, 0, 13, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(30, 0, 14, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(31, 0, 15, '2011-01-01', '-4.00', '-', 'Monatsbeitrag - Januar 2011'),
(32, 0, 16, '2011-01-01', '-2.00', '-', 'Monatsbeitrag - Januar 2011'),
(33, 0, 17, '2011-01-01', '-2.00', '-', 'Monatsbeitrag - Januar 2011'),
(34, 2, 6, '2011-01-17', '10.00', '+', 'Bareinzahlung - Monatsbeitrag'),
(35, 3, 11, '2011-01-17', '5.00', '+', 'Bareinzahlung - Monatsbeitrag'),
(36, 4, 4, '2011-01-17', '5.00', '+', 'Bareinzahlung - Monatsbeitrag'),
(37, 5, 7, '2011-01-17', '10.00', '+', 'Bareinzahlung - Monatsbeitrag'),
(38, 6, 8, '2011-01-18', '4.00', '+', 'Bareinzahlung - Monatsbeitrag'),
(39, 8, 14, '2011-01-19', '6.00', '+', 'Bareinzahlung - Sonstiges'),
(40, 9, 14, '2011-01-19', '-12.00', '-', 'Barauszahlung - Guthaben'),
(41, 10, 14, '2011-01-19', '-4.81', '-', 'Spende an Kaffeekasse');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitglieder_stamm`
--

DROP TABLE IF EXISTS `mitglieder_stamm`;
CREATE TABLE IF NOT EXISTS `mitglieder_stamm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `vorname` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `eintritt` date NOT NULL,
  `faktor` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=18 ;

--
-- Daten für Tabelle `mitglieder_stamm`
--

INSERT INTO `mitglieder_stamm` (`id`, `name`, `vorname`, `email`, `eintritt`, `faktor`) VALUES
(1, 'Beckmerhagen', 'Tobias', 'beckmerhagen@igg.uni-bonn.de', '2011-01-10', 'ma'),
(2, 'Behmann', 'Jan', 'behmann@igg.uni-bonn.de', '2011-01-10', 'hiwi'),
(3, 'Bonnauer', 'Daniel', 'bonnauer@igg.uni-bonn.de', '2011-01-10', 'hiwi'),
(4, 'Dehbi', 'Youness', 'dehbi@igg.uni-bonn.de', '2011-01-10', 'ma'),
(5, 'Dörschlag', 'Dirk', 'doerschlag@igg.uni-bonn.de', '2011-01-10', 'ma'),
(6, 'Fischer', 'Jean-Michel', 'jmf@polygonpunkt.de', '2011-01-10', 'hiwi'),
(7, 'Gröger', 'Gerd', 'groeger@igg.uni-bonn.de', '2011-01-10', 'ma'),
(8, 'Henn', 'André', 'henn@igg.uni-bonn.de', '2011-01-10', 'ma'),
(9, 'Kleinmanns', 'Jens', 'jens.kleinmanns@gmx.de', '2011-01-10', 'hiwi'),
(10, 'Kneuper', 'Michael', 'kneuper@igg.uni-bonn.de', '2011-01-10', 'ma'),
(11, 'Loch-Dehbi', 'Sandra', 'loch-dehbi@igg.uni-bonn.de', '2011-01-10', 'ma'),
(12, 'Plümer', 'Lutz', 'pluemer@igg.uni-bonn.de', '2011-01-10', 'ma'),
(13, 'Rumpf', 'Till', 'rumpf@igg.uni-bonn.de', '2011-01-10', 'ma'),
(14, 'Schmittwilken', 'Jörg', 'schmittwilken@igg.uni-bonn.de', '2011-01-10', 'ma'),
(15, 'Steinrücken', 'Jörg', 'steinruecken@igg.uni-bonn.de', '2011-01-10', 'ma'),
(16, 'Weile', 'Florian', 'weile@igg.uni-bonn.de', '2011-01-10', 'hiwi'),
(17, 'Welke', 'Pascal', 'welke@igg.uni-bonn.de', '2011-01-10', 'hiwi');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitglieder_status`
--

DROP TABLE IF EXISTS `mitglieder_status`;
CREATE TABLE IF NOT EXISTS `mitglieder_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maId` int(11) NOT NULL,
  `status` smallint(1) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `maId` (`maId`)
) TYPE=MyISAM  AUTO_INCREMENT=18 ;

--
-- Daten für Tabelle `mitglieder_status`
--

INSERT INTO `mitglieder_status` (`id`, `maId`, `status`, `datum`) VALUES
(1, 1, 1, '2011-01-10'),
(2, 2, 1, '2011-01-10'),
(3, 3, 1, '2011-01-10'),
(4, 4, 1, '2011-01-10'),
(5, 5, 0, '2011-01-21'),
(6, 6, 1, '2011-01-10'),
(7, 7, 1, '2011-01-10'),
(8, 8, 1, '2011-01-10'),
(9, 9, 1, '2011-01-10'),
(10, 10, 1, '2011-01-10'),
(11, 11, 1, '2011-01-10'),
(12, 12, 1, '2011-01-10'),
(13, 13, 1, '2011-01-10'),
(14, 14, 0, '2011-01-26'),
(15, 15, 1, '2011-01-10'),
(16, 16, 1, '2011-01-10'),
(17, 17, 1, '2011-01-10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `textbausteine`
--

DROP TABLE IF EXISTS `textbausteine`;
CREATE TABLE IF NOT EXISTS `textbausteine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titel` varchar(256) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `textbausteine`
--
