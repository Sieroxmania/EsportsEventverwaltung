<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>

<html>

<head>
    <title>Event editieren</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Einbindung Header mit include -->
<?php include ("header.php"); ?>


<?php
/**Prüft ob eine Session vorhanden ist, bzw. ob eine Emailadresse vorhanden ist
 * @param $email Emailadresse des Benutzers - aus Session
 */
if(!isset($_SESSION['email'])) {
    echo "<main><h1>Neues Event anlegen</h1><br>";
    echo "Bitte loggen Sie sich zuerst ein!<br><a href=\"login.php\">Login</a></main>";
    //Wenn nicht vorhanden, wird die Seite nicht weiter geladen
    die;
}else {
    //Wenn vorhanden, wird die Emailadresse in einer variablen gespeichert
    $email = ($_SESSION['email']);
}


/**Wir nach dem laden der Seite ausgeführt, bedingt durch die Weiterleitung durch 'eventAuswahl'
 * Holt saemtliche Informatioen zu der ausgewählten Veranstaltung aus der Datebank und speichert diese
 * in Variablen, damit diese anschließend in die Form geschrieben werden können.
 * String $eventId id des ausgewählten Events wird übergeben
 * String $result ergebnisse des Datenbank-querys
 * Integer $id ID des Events
 * String $eventname Eventname, gleichbleibend mit $eventId
 * String $spielname Spielname des Events
 * String $datum Datum des Events
 * Integer $teilnehmeranzahl Teilnehmeranzahl des Events
 * String $veranstalter Veranstalter des Events
 * Integer $preisgeld Preisgeld des Events
 * String $ort Ort des Events
 * String $gewinner Gewinner des Events, sofern bekannt
 * String $plattform Plattform des Spiels des Events
 * String $checkp wenn Plattform == PS4, dann wird radiobutton PS4 gecheckt
 * String checkx wenn Plattform == XBOX, dann wird radiobutton XBOX gecheckt
 * @param -
 */
require('db_connect.php');
if(isset ($_POST['eventAuswahl'])) {

    $eventId = ($_POST['eventAuswahl']);
    $_SESSION['id'] = $eventId;

    //prepared Statement zur Datenbankabfrage, alle gespeicherten Informationen vom ausgewählten Event
    $stmt = $mysqli->prepare("SELECT eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform FROM event WHERE emailadresse = ? AND id_event = ?");
    $stmt->bind_param('si', $email, $eventId);
    $stmt->execute();


    if ($stmt->execute()) {
        $stmt->bind_result($eventname, $spielname, $datum, $teilnehmeranzahl, $veranstalterverweis, $preisgeld, $ort, $gewinner, $plattform);
        $stmt->store_result();
    }

    if ($stmt->num_rows > 0) {

        /* fetch values */
        while ($stmt->fetch()) {
            $eventname = $eventname;
            $spielname = $spielname;
            $datum = $datum;
            $teilnehmeranzahl = $teilnehmeranzahl;
            $veranstalter = $veranstalterverweis;
            $preisgeld = $preisgeld;
            $ort = $ort;
            $gewinner = $gewinner;
            $plattform = $plattform;
        }

        $checkp = "";
        $checkx = "";
        if ($plattform == "XBOX") {
            $checkx = "checked";
        } else {
            $checkp = "checked";
        }
    }
}

/**Wenn der Button speichern gedrückt worden ist, werden die Änderungen in der Datebank gespeichert
 * String $eventId ausgewählter Eventname, vom Event, dass gemeldet werden soll
 * String $eventname Eventname, gleichbleibend mit $eventId
 * String $spiel Spielname des Events
 * String $datum Datum des Events
 * Integer $teilnehmeranzahl Teilnehmeranzahl des Events
 * String $veranstalter Veranstalter des Events
 * Integer $preisgeld Preisgeld des Events
 * String $ort Ort des Events
 * String $gewinner Gewinner des Events, sofern bekannt
 * String $plattform Plattform des Spiels des Events
 * @param -
 */
if (isset($_POST['speichern'])){
    $eventId = $_SESSION['id'];
     $datum = $mysqli->real_escape_string($_REQUEST['datum']);
    $eventname = $mysqli->real_escape_string($_REQUEST['eventname']);
    $spiel = $mysqli->real_escape_string($_REQUEST['spieletitel']);
    $teilnehmeranzahl = $mysqli->real_escape_string($_REQUEST['teilnehmeranzahl']);
    $veranstalter = $mysqli->real_escape_string($_REQUEST['veranstalter']);
    $preisgeld = $mysqli->real_escape_string($_REQUEST['preisgeld']);
    $ort = $mysqli->real_escape_string($_REQUEST['ort']);
    $plattform = $mysqli->real_escape_string($_REQUEST['plattform']);
    $gewinner = $mysqli->real_escape_string($_REQUEST['gewinner']);

    //prepared Statement zur Datenbankabfrage, Informationen in der Datenbank sollen geupdatet werden
    $stmt = $mysqli->prepare("UPDATE event SET eventname = ?, spielname = ?, datum = ?, teilnehmeranzahl = ?, veranstalterverweis = ?, preisgeld = ?, ort = ?, gewinner = ?, plattform = ?  
    WHERE emailadresse = ? AND id_event = ?");
    $stmt->bind_param('sssisissssi', $eventname, $spiel, $datum, $teilnehmeranzahl, $veranstalter, $preisgeld, $ort, $gewinner, $plattform, $email, $eventId);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    //Nach dem erfolgreichen Speichern, wird der Benutzer zurück zur Übersicht seiner Events weitergeleitet.
    header("Location: meine_events.php");
}


/**Wenn der Button löschen gedrückt worden ist, soll das ausgewählte Event gelöscht werden, inklusive seiner Meldungen
 * String $eventname Nachricht, die an die Meldung angehängt wird, eingegeben vom Benutzer
 * Integer $id ID vom Event, dass gemeldet werden soll
 * String $email Emailadresse vom eingeloggten Benutzer
 * @param -
 */
if (isset ($_POST['löschen'])) {
//Wenn ein Event ausgewählt wird, kann man es löschen, nach ausgewähltem Namen und der EmailAdresse
    $eventId = $_SESSION['id'];
    $email = $_SESSION['email'];
    $eventname = $mysqli->real_escape_string($_REQUEST['eventname']);

    //prepared Statement zur Datenbankabfrage, das Event wird gelöscht
    $stmt = $mysqli->prepare("DELETE FROM event WHERE emailadresse = ? AND id_event = ?");
    $stmt->bind_param('ss', $email, $eventId);
    $stmt->execute();

    //prepared Statement zur Datenbankabfrage, die Meldungen zum event werden gelöscht
    $stmt = $mysqli->prepare("DELETE FROM meldung WHERE emailadresse = ? AND id_event = ?");
    $stmt->bind_param('ss', $email, $eventId);
    $stmt->execute();

    $stmt->close();
    $mysqli->close();

    //Nach dem erfolgreichen Löschen, wird der Benutzer zurück zur Übersicht seiner Events weitergeleitet.
    header("Location: meine_events.php");
}
?>

<main>

    <section id="form">
        <h2>Event bearbeiten</h2>
        <form name="eventformular" id="eventformular" method="post">
            <p>
            <fieldset>
                Eventname:
                <!-- Hier wird der Eventname des ausgewählten Events eingetragen -->
                <input type="text" id="eventname" class="text" name="eventname"
                       minlength="1" maxlength="20" value="<?php echo $eventname?>">

                Spieltitel:
                <!-- Hier wird der Spielname des ausgewählten Events weitergeleitet -->
                <select id="Spieltitel" id="titel" name="spieletitel" onchange="alert(<?php echo $spielname?>)">
                    <option value="Call of Duty">Call of Duty</option>
                    <option value="Counter Strike">Counter Strike</option>
                    <option value="Hearthstone"> Hearthstone </option>
                    <option value="Fifa">Fifa </option>
                    <option value="League of Legends">League of Legends</option>
                    <option value="Playerunknowns Battlegrounds">Playerunknowns Battlegrounds</option>
                    <option value="Pokemon">Pokemon</option>
                    <option value="Rocket League"> Rocket League </option>
                    <option value="World of Warcraft"> World of Warcraft</option>
                    <option value="Yu-Gi-Oh-Duel Links">Yu-Gi-Oh-Duel Links</option>
                </select><br>

                Teilnehmer:
                <!-- Hier wird die teilnehmeranzahl des ausgewählten Events eingetragen -->
                <input type="number" id="teilnehmer" class="text" name="teilnehmeranzahl"
                       min="4" max="128" step="2" value="<?php echo $teilnehmeranzahl?>"required>

                Preisgeld in Euro:
                <!-- Hier wird das Preisgeld des ausgewählten Events eingetragen -->
                <input type="number" id="preisgeld" class="text" name="preisgeld" value="<?php echo $preisgeld?>"required><br>

                Plattform:
                <br>
                <label for="mc"> PS4</label>
                <!-- Hier wird die entsprechende Plattform geheckt, in Abhänigkeit von $checkp -->
                <input type="radio" id="ps4" name="plattform" value="PS4" class="plattform" <?php echo $checkp?>>

                <br>
                <label for="vi"> XBOX</label>
                <!-- Hier wird die entsprechende Plattform geheckt, in Abhänigkeit von $checkx -->
                <input type="radio" id="xbox" name="plattform" value="XBOX" class="plattform"<?php echo $checkx?>>
                <br>

                </br>
                <!-- Hier wird der Ort des ausgewählten Events eingetragen -->
                Ort: <input type="text" name="ort" id="ort" value="<?php echo $ort?>" class="text">
                <br>

                Datum:
                <!-- Hier wird das Datum des ausgewählten Events eingetragen -->
                <input type="date" id="datum" name="datum" value="<?php echo $datum?>"
                       required><br>

                Veranstalter:
                <!-- Hier wird der Veranstalter des ausgewählten Events eingetragen -->
                <input type="text" id="veranstalter" class="text" name="veranstalter" value="<?php echo $veranstalter?>"
                       required><br>

                Gewinner:
                <!-- Hier wird der Gewinner des ausgewählten Events eingetragen -->
                <input type="text" id="gewinner" class="text" name="gewinner" value="<?php echo $gewinner?>"><br>

                <input type="submit" id="löschen" value="Löschen" name="löschen">

                <input type="submit" id="erstellen" value="Speichern" name="speichern">

            </fieldset>
        </form>
    </section>

</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>

</body>

</html>