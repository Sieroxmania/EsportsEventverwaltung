<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>

<html>

<head>
    <link rel="stylesheet" href="css/style.css">
    <title>Event anlegen</title>
    <meta charset="UTF-8"/>
</head> 
<body>




<?php include ("header.php"); ?>



<?php
if(!isset($_SESSION['email'])) {
    echo "<main><h1>Neues Event anlegen</h1><br>";
    echo "Bitte loggen Sie sich zuerst ein!<br><a href=\"login.php\">Login</a></main>";
    die;
}else {
    $email = ($_SESSION['email']);

}?>



<?php
require('db_connect.php');
// If form submitted, insert values into the database.
if (isset($_POST['erstellen'])){

//SQL injection
    $datum = $mysqli->real_escape_string($_REQUEST['datum']);
   $eventname = $mysqli->real_escape_string($_REQUEST['eventname']);
    $spiel = $mysqli->real_escape_string($_REQUEST['spieletitel']);
    $teilnehmeranzahl = $mysqli->real_escape_string($_REQUEST['teilnehmeranzahl']);
    $veranstalter = $mysqli->real_escape_string($_REQUEST['veranstalter']);
    $preisgeld = $mysqli->real_escape_string($_REQUEST['preisgeld']);
    $ort = $mysqli->real_escape_string($_REQUEST['ort']);
    $plattform = $mysqli->real_escape_string($_REQUEST['plattform']);
    $gewinner = "TBA";


    $stmt = $mysqli->prepare("INSERT INTO event (emailadresse, eventname, spielname, datum, teilnehmeranzahl, veranstalterverweis, preisgeld, ort, gewinner, plattform) VALUES (?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssisisss', $email, $eventname, $spiel, $datum, $teilnehmeranzahl, $veranstalter, $preisgeld, $ort, $gewinner, $plattform);
    $stmt->execute();

    $stmt->close();
}
else {


    $mysqli->close();
}
?>




<main>
    <!-- Änderung -->

    <section id="form">
        <h2>Event erstellen</h2>
        <form name="eventformular" id="eventformular" method="post">
            <p>
            <fieldset>
                Eventname:
                <input type="text" id="eventname" class="form" name="eventname"
                       minlength="1" maxlength="20">



                Spieltitel:
                <select id="Spieltitel" id="titel" name="spieletitel">
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
                <input type="number" id="teilnehmer" class="form" name="teilnehmeranzahl"
                       min="4" max="128" step="2" required>

                Preisgeld in Euro:
                <input type="number" id="preisgeld" class="form" name="preisgeld" required><br>

                Plattform:
                <br>
                <label for="mc"> PS4</label>
                <input type="radio" id="ps4" name="plattform" value="PS4" class="plattform">

                <br>
                <label for="vi"> XBOX</label>
                <input type="radio" id="xbox" name="plattform" value="XBOX" class="plattform">
                <br>


                </br>

                Ort: <input type="text" name="ort" id="ort" class="form">
                <br>



                Datum:
                <input type="date" id="datum" name="datum"
                       required><br>
                <br>
                Veranstalter:
                <input type="text" id="veranstalter" class="form" name="veranstalter"
                       required><br>
                <input type="button" id="abbrechen" value="Abbrechen">

                <input type="submit" id="erstellenf" value="Erstellen" name="erstellen">

            </fieldset>


        </form>

</main>


<?php include ("footer.php"); ?>

</body>

</html>