<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrieren</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/register.js"></script>
</head>

<body>

<!-- Einbindung Header mit include -->
<?php include ("header.php"); ?>


<main>

    <?php
    require('db_connect.php');
    /**
     * Wenn das Formular submitted wird, soll Vorgang des Registrierens gestartet werden
     * $benutzername eingegebener Benutzername des Benutzers
     * $emailadresse eingegebene Emailadresse des Benutzers
     * $passwort eingegebenes Passwort des Benutzers
     * $hash gehashtes Password mit sha256
     */
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        //SQL injection durch prepared Statement und stripslashes & character escape verhindern
        $benutzername = stripslashes($_REQUEST['benutzername']); //entfernt backslashes
        $benutzername = mysqli_real_escape_string($mysqli, $benutzername); //special character escape in Strings
        $emailadresse = stripslashes($_REQUEST['emailadresse']);
        $emailadresse = mysqli_real_escape_string($mysqli, $emailadresse);
        $passwort = stripslashes($_REQUEST['passwort']);
        $passwort = mysqli_real_escape_string($mysqli, $passwort);
        $hash = hash('sha256', $passwort);

        //prepared Statement zur Datenbankabfrage, ob schon ein konto mit dieser Emailadresse exisitert
        $stmt = $mysqli->prepare("SELECT emailadresse FROM benutzer WHERE emailadresse = ? LIMIT 1");
        $stmt->bind_param('s', $emailadresse);
        $stmt->execute();
        $stmt->bind_result($emailadresse);
        $stmt->store_result();

        //Prüfung ob ein Ergebnis bei der Abfrage herauskommt
        if ($stmt->num_rows == 1) {
            //Wenn Email bereits existiert
            while ($stmt->fetch()) {//fetching the contents of the row
                echo "<div class='form'><h3>Diese E-Mailadresse existiert schon in unserer Datenbank!</h3><br/>Klicke hier um dich zu registrieren: <a href='registrieren.php'>Registration</a></div>";
                echo $emailadresse;
            }
            //Wenn Email nicht existiert, wird der Benutzer in der Datenbank gespeichert
        } else {
            $register = $mysqli->prepare("INSERT INTO benutzer (emailadresse, benutzername, passwort) 
            VALUES (?, ?, ?)");
            $register->bind_param("sss", $emailadresse, $benutzername, $hash);
            $register->execute();
            $register->close();
            echo "<div class='form'><h3>Dein Account wurde erfolgreich angelegt.</h3><br/>Klicke hier um dich einzuloggen: <a href='login.php'>Login</a></div>";
        }
        $stmt->close();
        $mysqli->close();
    }else{
    ?>

        <div class="regform">
            <h1>Registration</h1>
            <form name="Registration" id="registration" action="" method="post">
                <input class="reg" type="text" name="benutzername" id="benutzername" placeholder="Benutzername" minlength="4" required /> <br>
                <input class="reg" type="email" name="emailadresse" id="emailadresse" placeholder="Email" required /><br>
                <input class="reg" type="password" name="passwort" id="passwort" placeholder="Passwort" minlength="6" required /><br>
                <input class="reg" type="password" name="passwortw" id="passwortw" placeholder="Passwort wiederholen" minlength="6" required /><br>
                <!-- Bei klick auf Button - Überprüfung des ausgefüllten Formulars auf bestimmte Vorgaben wie length -->
                <input class="reg"type="button" name='regbutton' id="regbutton" onclick="checkform()" value="Submit">
                <input class="reg"type="button" value="Abbrechen" onclick="history.back()">

            </form>

            <br /><br />

        </div>
    <?php } ?>


</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>

</body>
</html>







