<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */


/**Wenn be_erstellen nach der weiterleitung übergeben wird, soll ein Testbenutzer und Beispielevents für diesen angelegt werden
 * Die Beispielevents sollen mithilfe der datei testeventsAnlegen.json erstellt werden.
 * String $email Emailadresse des Testbenutzer
 * String $benutzer Benutzername des Testbenutzer
 * String $passwort Passwort des Testbenutzer
 * String $hash gehashtes Passwort des Testbenutzers mit sha256
 * String $filename Name der zu benutzenden Json-Datei
 * String $array Enthält die Daten der JSON-Datei in einem Array
 */
require('db_connect.php');
if(isset($_POST['be_erstellen'])){

    //prepared Statement zur Datenbankabfrage, löscht alle Einträge in der Tabelle event
    $stmt = $mysqli->prepare("TRUNCATE TABLE event");
    $stmt->execute();

    //prepared Statement zur Datenbankabfrage,  löscht alle Einträge in der Tabelle meldung
    $stmt = $mysqli->prepare("TRUNCATE TABLE meldung");
    $stmt->execute();

    if ($stmt){
        $email = "test@test.de";
        $benutzer = "Testbenutzer";
        $passwort = "test12";
        $hash = hash('sha256', $passwort);

        //prepared Statement zur Datenbankabfrage, erstellt den Testbenutzer
        $register = $mysqli->prepare("INSERT INTO benutzer (emailadresse, benutzername, passwort) 
            VALUES (?, ?, ?)");
        $register->bind_param("sss", $email, $benutzer, $hash);
        $register->execute();
        $register->close();
    }
    //Wenn das anlegen des Testbenutzer geklappt hat
    if ($register){

        $filename = "testeventsAnlegen.json";
        $data = file_get_contents($filename); //Liest das JSON File in PHP ein
        $array = json_decode($data, true); //Konvertiert die JSON Datei in ein PHP Array
        foreach ($array as $row) //Erstellt prepared Statements zum anlegen der Beispielevents mit den Values des Arrays und führt diese dann aus in einer Foreach-Schleife
        {

            //prepared Statement zur Datenbankabfrage, erstellt die Beispielevents
            $stmt = $mysqli->prepare("INSERT INTO event (emailadresse, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssisisss',  $email,  $row["eventname"],  $row["spielname"],  $row["datum"],  $row["teilnehmeranzahl"],  $row["veranstalterverweis"],  $row["preisgeld"],  $row["ort"],  $row["gewinner"],  $row["plattform"]);
            $stmt->execute();
        }

        //Nach dem anlegen des Testbenutzers und der Beispielevents, wird der Benutzer zum Login weitergeleitet.
        header("Location: login.php");
        exit();
    }
}

/**Wenn e_erstellen nach der weiterleitung übergeben wird, sollen Beispielevents für den eingeloggten Benutzer erstellt werden
 * String $email Emailadresse des eingeloggten Benutzers
 * String $filename Name der zu benutzenden Json-Datei
 * String $array Enthält die Daten der JSON-Datei in einem Array
 */
if(isset($_POST['e_erstellen'])) {
    session_start();

    //prepared Statement zur Datenbankabfrage, löscht alle Einträge in der Tabelle event
    $stmt = $mysqli->prepare("TRUNCATE TABLE event");
    $stmt->execute();

    //prepared Statement zur Datenbankabfrage,  löscht alle Einträge in der Tabelle meldung
    $stmt = $mysqli->prepare("TRUNCATE TABLE meldung");
    $stmt->execute();

    //Wenn das Löschen der Tabellen geklappt hat
    if ($stmt) {

        $email = $_SESSION['email'];
        $filename = "testeventsAnlegen.json";
        $data = file_get_contents($filename); //Liest das JSON File in PHP ein
        $array = json_decode($data, true); //Konvertiert die JSON Datei in ein PHP Array
        foreach ($array as $row) //Erstellt prepared Statements zum anlegen der Beispielevents mit den Values des Arrays und führt diese dann aus in einer Foreach-Schleife
        {
            //prepared Statement zur Datenbankabfrage, erstellt die Beispielevents
            $stmt = $mysqli->prepare("INSERT INTO event (emailadresse, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssisisss',  $email,  $row["eventname"],  $row["spielname"],  $row["datum"],  $row["teilnehmeranzahl"],  $row["veranstalterverweis"],  $row["preisgeld"],  $row["ort"],  $row["gewinner"],  $row["plattform"]);
            $stmt->execute();
        }
        //Nach dem anlegen der Beispielevents, wird der Benutzer zu seinen Events weitergeleitet.
        header("Location: meine_events.php");
}
}
?>