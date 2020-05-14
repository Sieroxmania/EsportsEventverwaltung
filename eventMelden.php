<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>


<html>

<head>
    <title>Event melden</title>
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
    echo "<main><h1>Event melden</h1><br>";
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
 * String $eventId ID vom ausgewählten Event
 * String $result ergebnisse des Datenbank-querys
 * Integer $id ID des Events
 * String $eventname Eventname, gleichbleibend mit $eventId
 * @param -
 */
require('db_connect.php');
if(isset ($_POST['eventAuswahl'])) {
    $eventId = ($_POST['eventAuswahl']);
    $_SESSION['id'] = $eventId;

    //prepared Statement zur Datenbankabfrage, holt id und name vom Event zum späteren Melden
    $stmt = $mysqli->prepare("SELECT id_event, eventname FROM event WHERE id_event = ?");
    $stmt->bind_param('s', $eventId);
    $stmt->execute();

    if ($stmt->execute()) {
        $stmt->bind_result($id_event, $eventname);
        $stmt->store_result();
    }

    if ($stmt->num_rows > 0) {

        /* fetch values */
        while ($stmt->fetch()) {
            $id = $eventId;
            $eventname = $eventname;
        }

    }
}

/**Wenn der Button melden gedrückt worden ist, wird ein Datenbank Eintrag erstellt (Meldung)
 * String $Nachricht Nachricht, die an die Meldung angehängt wird, eingegeben vom Benutzer
 * Integer $id ID vom Event, dass gemeldet werden soll
 * String $email Emailadresse vom eingeloggten Benutzer
 * @param -
 */
if(isset ($_POST['melden'])) {
    //SQL injection durch prepared Statement und stripslashes & character escape verhindern
    $nachricht = htmlspecialchars($_POST['meldung']);
    $nachricht = mysqli_real_escape_string($mysqli, $nachricht); //special character escape in Strings
    $eventId = $_SESSION['id'];

    //prepared Statement zur Datenbankabfrage, erstellt Datenbank eintrag (Meldung)
    $melden = $mysqli->prepare("INSERT INTO meldung (id_event, emailadresse, text) 
            VALUES (?, ?, ?)");
    $melden->bind_param("sss", $eventId, $email, $nachricht);
    $melden->execute();
    $melden->close();

    //Nach dem erfolgreichen melden, wird der Benutzer zurück zu Eventübersicht weitergeleitet.
    header("Location: events.php");
}
?>



<main>

    <section id="form">
        <h2>Event melden</h2>
        <form name="eventMelden" id="eventMelden" method="post">
            <p>
                <fieldset>
                 <p>Eventname:</p>
                 <!-- Hier wird der Eventname des ausgewählten Events eingetragen -->
                <input type="text" id="eventname" class="text" name="eventname"
                   minlength="1" maxlength="20" value="<?php echo $eventname?>">
                 <br>
                 <br>
                <p>Meldungsgrund:</p>
                 <textarea rows="8" cols="40" name="meldung" id="meldung">Meldungsgrund...
                 </textarea>
                 <br>
                 <br>
                 <input type="button" id="abbrechen" value="Abbrechen" name="abbrechen">
                 <input type="submit" id="melden" value="Melden" name="melden">
                 </fieldset>
        </form>
    </section>


</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>

</body>

</html>