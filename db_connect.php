<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */


// Die Konfiguration für mysqli wird als Array aus der config.ini geladen
$config = parse_ini_file('config.ini');

// Try and connect to the database
$mysqli = new mysqli('localhost',$config['username'],$config['password'],$config['dbname']);

// If connection was not successful, handle the error
if($mysqli === false) {
    echo "Fehler bei der Verbindung: " . mysqli_connect_error();
    exit();
}else{
    echo "Verbindung hat geklappt <br>";
}

//Prüft ob charset auf UTF8 gesetzt ist, wenn nicht wird ein Fehler ausgegeben
if (! $mysqli->set_charset("utf8") ) {

    echo "Fehler beim Laden von UTF8 ". $mysqli->error;
}

?>