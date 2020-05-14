<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>


<html>
<head>
    <title>Meine Events</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/AJAXTableDropdown.js"></script>
</head>

<!-- Beim Laden des Bodys - Erstellen des Tables und der Drowdown-Liste für eigene Events-->
<body onload="getTableDataAJAX(), erstelleAuswahl()">

<!-- Einbindung Header mit include -->
<?php include ("header.php"); ?>



<?php
/**Prueft ob eine Session vorhanden ist, bzw. ob eine Emailadresse vorhanden ist
 * $email Emailadresse des Benutzers - aus Session
 */
if(!isset($_SESSION['email'])) {
    echo "<main><h1>Meine Events</h1><br>";
    echo "Bitte loggen Sie sich zuerst ein!<br><a href=\"login.php\">Login</a></main>";
    //Wenn nicht vorhanden, wird die Seite nicht weiter geladen
    die;
}else{
    //Wenn vorhanden, wird die Emailadresse in einer variablen gespeichert
   $email = $_SESSION['email'];
}

/**Ruft die Funktion erstelleJson auf und uebergibt
 * String $sql query das Anzeigen der erstellen Events des Benutzers
 */
include ("erstelleJson.php");
$sql= "SELECT id_event, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform FROM event WHERE emailadresse = ?";
if(erstelleJsonVar($sql, $email) == "true"){
    $optionDisabled = "enabled";
}else{
    $optionDisabled = "disabled";
}
?>


<main>

    <?php
    /**Ruft die Funktion erstelleJson auf, wenn der Button "sortieren" gedrueckt wird, uebergibt
     * String $sql query das Anzeigen der erstellen Events des Benutzers
     * String $sort ausgewählter Sortierungsbegriff
     */
    if (isset ($_POST['sort'])) {
        $sort=$_POST['sort'];
        $sql = "SELECT id_event, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform FROM event WHERE emailadresse = ? ORDER BY $sort DESC";
        erstelleJsonVar($sql, $email);
    }
    ?>


    <aside>
        <ul id="myevents_side">
            <li><h2>Einstellungen</h2></li>
            <form action="" method="post">
                Sortieren nach:<br>
                <select name="sort" size="1" <?php echo $optionDisabled ?>>
                    <option value="datum">Datum</option>
                    <option value="plattform">Plattform</option>
                    <option value="preisgeld">Preisgeld</option>
                    <option value="eventname">Eventname</option>
                    <option value="spielname">Spielname</option>
                </select>
                <br>
                <input class="settingse" type=submit value="anwenden" <?php echo $optionDisabled ?>>
            </form>
            <br>
        <form method="post" action="eventEditDelete.php" >
            <!-- element für das Einfügen der Dropdown-Auswahl an Events aus der JSON-Datei "allEvents"-->
            <select id="event-dropdown" name="eventAuswahl" <?php echo $optionDisabled ?> >
            </select>
            <br>
            <input class="settingse" type=submit name="eventnameE" value="bearbeiten" <?php echo $optionDisabled ?> >
        </form>
        </ul>
    </aside>



    <h1>Meine Events</h1>
    <!-- div für das Erstellen des Tables aus der angelegten JSON-Datei "allEvents"-->
    <div id="ajaxTable"></div>

</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>

</body>

</html>