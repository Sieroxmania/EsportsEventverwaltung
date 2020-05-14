<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>

<html>
<head>
    <title>Einstellungen</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" type="text/css" title="normal" href="css/style.css">
</head>
<body>

<!-- Einbindung Header mit include -->
<?php include ("header.php"); ?>

<?php
/**
* Bei keiner verfügbarer Session soll der Events erstellen-Button ausgegraut werden, andernfalls der Logout-Button
* @param String $disableEvents
*/
$disableEvents = "";

if (!isset($_SESSION['email'])) {
$disableEvents = "disabled=disabled";
}
?>

<main>

    <h1>Einstellungen</h1>
    <section>
        <article>
        <h2>Datenbank - Einstellungen</h2>
        <form method="post" action="db_testdaten.php">
            <br>
            <p>Erstellt einen Testbenutzer und 5 Beispielevents. Löscht alle anderen Events und Ihre Meldungen.
                <!-- ruft bei Klick die Funktion testBenutzter() auf -->
            <input type="submit" id="be_erstellen" value="Testbenutzer & Events erstellen" name="be_erstellen" onclick="testBenutzer()"/>
            <br>
            <br>
            <p>Erstellt für einen Benutzer 5 Beispielevents. Löscht alle anderen Events und Ihre Meldungen.</p>
            <!-- Wird bei keiner verfübaren Session ausgegraut -->
            <input type="submit" id="e_erstellen" value="Events erstellen" name="e_erstellen" <?php echo $disableEvents;?>/>
        </form>
        </article>
        <article>
            <h2>Homepage - Einstellungen</h2>

        </article>
    </section>

    <!-- Gibt den Benutzernamen und das Passwort für den Testbenutzer als Alert aus -->
    <script>
        function testBenutzer() {
            alert("Es wird folgender Testbenutzer angelegt:\nEmail: test@test.de \nPasswort: test12");
        }
    </script>

</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>

</body>
</html>