
<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>


<html>
<head>
    <title>Startseite</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/AJAXTableDropdown.js"></script>
</head>

<!-- Beim Laden des Bodys - Erstellen der Upcoming Events-->
<body onload="getTableDataAJAX()">

<!-- Einbindung Header mit include -->
<?php
include ("header.php");
?>


<main>

    <h1>Esports Eventverwaltung</h1>
    <section>
        <a id="controller" class='logo' href="index.php"><img src="img/home_ps4.jpeg" align=left width=80% height=30% alt="logo"></a>
    </section>


    <?php
    /**Ruft die Funktion erstelleJsonHome auf und übergibt
     * @param String $sql query für upcoming Events
     */
    include ("erstelleJson.php");
    $sql = "SELECT id_event, eventname, datum FROM event ORDER BY datum ASC LIMIT 5";
    erstelleJsonHome($sql);
    ?>

    <aside>
        <ul id="event_side">
            <li><h2 id="upcoming">Upcoming Events - Short</h2> </li>
            <!-- div für das Erstellen der Table aus der angelegten JSON-Datei -->
            <div id="ajaxTable"></div>

        </ul>
    </aside>

</main>

<!-- Einbindung Footer mit include -->
<?php
include ("footer.php");
?>

</body>

</html>