-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 31. Jan 2018 um 20:56
-- Server-Version: 5.5.52-0ubuntu0.14.04.1
-- PHP-Version: 5.5.9-1ubuntu4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `dgsql4`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `emailadresse` varchar(50) NOT NULL,
  `benutzername` varchar(20) NOT NULL,
  `passwort` varchar(500) NOT NULL,
  `profilbildurl` varchar(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewertung`
--

CREATE TABLE `bewertung` (
  `id_event` int(11) DEFAULT NULL,
  `emailadresse` varchar(20) DEFAULT NULL,
  `sterne` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `event`
--

CREATE TABLE `event` (
  `id_event` int(10) UNSIGNED NOT NULL,
  `emailadresse` varchar(50) NOT NULL,
  `eventname` varchar(40) NOT NULL,
  `spielname` varchar(40) NOT NULL,
  `datum` date NOT NULL,
  `teilnehmeranzahl` int(10) UNSIGNED NOT NULL,
  `veranstalterverweis` varchar(40) NOT NULL,
  `preisgeld` int(10) UNSIGNED DEFAULT NULL,
  `ort` varchar(40) DEFAULT NULL,
  `gewinner` varchar(40) DEFAULT NULL,
  `plattform` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `meldung`
--

CREATE TABLE `meldung` (
  `id_event` int(11) NOT NULL,
  `emailadresse` varchar(20) NOT NULL,
  `text` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`emailadresse`);

--
-- Indizes für die Tabelle `bewertung`
--
ALTER TABLE `bewertung`
  ADD KEY `id_event` (`id_event`),
  ADD KEY `emailadresse` (`emailadresse`);

--
-- Indizes für die Tabelle `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `emailadresse` (`emailadresse`);

--
-- Indizes für die Tabelle `meldung`
--
ALTER TABLE `meldung`
  ADD KEY `id_event` (`id_event`),
  ADD KEY `emailadresse` (`emailadresse`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
