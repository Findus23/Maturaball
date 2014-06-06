-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Jun 2014 um 20:14
-- Server Version: 5.6.16
-- PHP-Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `maturaball`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE IF NOT EXISTS `benutzer` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`user_id`, `name`, `password`) VALUES
(1, 'Lukas', '0b9b81bf4feb6190fa041336bbf07574695913db6aacfc0ae18c924f459193c2'),
(2, 'neu', 'dfgdffdgdfdf');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservierungen`
--

CREATE TABLE IF NOT EXISTS `reservierungen` (
  `reserv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vorname` varchar(15) NOT NULL,
  `nachname` varchar(15) NOT NULL,
  `telefonnummer` varchar(20) NOT NULL,
  `email` varchar(25) DEFAULT NULL,
  `anzahl` int(2) unsigned NOT NULL,
  `anmerkung` varchar(500) DEFAULT NULL,
  `datum` datetime NOT NULL,
  `bezahlt` tinyint(1) DEFAULT NULL,
  `bearbeiter` int(10) unsigned DEFAULT NULL,
  `bearb_datum` datetime DEFAULT NULL,
  PRIMARY KEY (`reserv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Daten für Tabelle `reservierungen`
--

INSERT INTO `reservierungen` (`reserv_id`, `vorname`, `nachname`, `telefonnummer`, `email`, `anzahl`, `anmerkung`, `datum`, `bezahlt`, `bearbeiter`, `bearb_datum`) VALUES
(1, 'Lukas', 'Winkler', '1234', 'example@example.com', 3, NULL, '2014-06-05 06:14:33', 1, 2, NULL),
(8, 'as', 'assf', 'dads', 'email@email.com', 10, 'Anmerkung\r\nmit Zeilenumbruch', '2014-06-05 16:43:58', NULL, NULL, NULL),
(9, 'Gerhard', 'Kapeller', '436646443219', 'ing.kapeller@aon.at', 3, 'Anmerkung', '2014-06-06 13:02:37', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
