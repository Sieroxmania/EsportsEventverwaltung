<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>


<html>
<head>
    <title>Eventuebersicht</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/AJAXTableDropdown.js"></script>
</head>

<!-- Beim Laden des Bodys - Erstellen des Tables und der Drowdown-Liste für Events-->
<body onload="getTableDataAJAX(), erstelleAuswahl()">

<!-- Einbindung Header mit include -->
<?php include ("header.php"); ?>

<main>

<?php
/**Ruft die Funktion erstelleJson auf und übergibt
 * String $sql query für das Anzeigen aller erstellen Events
 * @param -
 */
include ("erstelleJson.php");
$sql= "SELECT id_event, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform FROM event";
if(erstelleJson($sql) == "true"){
    $optionDisabled = "enabled";
}else{
    $optionDisabled = "disabled";
}

?>

    <br><h1>Eventübersicht</h1>
    <br>
    <form id ="searchForm" name = "search" class="search" method="post">
        <label>
            <input type="search" name = "eingabe" placeholder="Was suchen Sie?"/>
        </label>
        <button type="submit" id="suchBtn">Suchen</button>
        <input type="radio" id="Spielname" name="suche" value="spielname" required> Spielname
        <input type="radio" id="Eventname" name="suche" value="eventname"required> Eventname
        <input type="radio" id="Plattform" name="suche" value="plattform"required> Plattform
    </form>

    <!-- div für das Erstellen des Tables aus der angelegten JSON-Datei -->
    <div id="ajaxTable"></div>



<?php
/**Wenn der Button Suche gedrückt worden ist, wird die Funktion erstelleJson aufgerufen und übergibt
 * String $sql query für das Anzeigen der gesuchten Events
 * String $suche ausgewählte Kategorie (Spielname / Eventname / Plattform)
 * String $eingabe eingegebener Suchebriff vom Benutzer
 * @param -
 */
    if(isset($_POST['suche'])){
    $suche = ($_POST['suche']);
    $eingabe = $mysqli->real_escape_string($_REQUEST['eingabe']);

    $sql = "SELECT id_event, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform FROM event WHERE $suche LIKE ?";
        if(erstelleJsonLike($sql, $eingabe) == "true"){
            $optionDisabled = "enabled";
        }else{
            $optionDisabled = "disabled";
        }
    }

/**Wenn der Button Sortieren gedrückt worden ist, wird die Funktion erstelleJson aufgerufen und übergibt
 * @param String $sql query für das Anzeigen der aller Events - absteigend sortiert nach
 * @param String $sort ausgewählter Sortierungsbegriff
 */
if (isset ($_POST['sort'])) {
    $sort=$_POST['sort'];

    $sql = "SELECT id_event,eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform FROM event ORDER BY $sort DESC";
    erstelleJson($sql);
}
?>

    <aside>
        <ul id="event_side2">
            <li id="settingse"><h2>Einstellungen</h2></li>
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
                <input class="settingse" type=submit value="Sortieren" <?php echo $optionDisabled ?>>
            </form>
            <br>
            <!-- action beim drücken des Melden-Buttons - weiterleitung auf eventMelden.php -->
          <form action="eventMelden.php" method="post">
              <!-- element für das Einfügen der Dropdown-Auswahl an Events aus der JSON-Datei "allEvents"-->
            <select id="event-dropdown" name="eventAuswahl" <?php echo $optionDisabled ?>>
            </select>
            <br>
            <input class="settingse" type=submit value="melden" name="eventMelden" <?php echo $optionDisabled ?>>
        </form>

        </ul>
    </aside>



</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>

</body>



</html>