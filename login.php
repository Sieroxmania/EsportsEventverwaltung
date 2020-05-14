<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/login.js"></script>
</head>

<body>

<!-- Einbindung Header mit include -->
<?php include ("header.php"); ?>

<main>

    <?php
    require('db_connect.php');
    /**
     * Wenn das Formular submitted wird, soll Vorgang des Einloggens gestartet werden
     * $email eingegebene Emailadresse des Benutzers
     * $passwort eingegebenes Passwort des Benutzers
     * $hash gehashtes Password mit sha256
     * @param -
     */
    if (isset($_POST['submit'])){
        //SQL injection durch prepared Statement und stripslashes & character escape verhindern
        $email = stripslashes($_REQUEST['email']); //entfernt backslashes
        $email = mysqli_real_escape_string($mysqli,$email);//special character escape in Strings
        $passwort = stripslashes($_REQUEST['passwort']);
        $passwort = mysqli_real_escape_string($mysqli,$passwort);
        $hash = hash('sha256', $passwort);

            //prepared Statement zur Datenbankabfrage, ob die Kombination aus Email und passwort existiert
            $stmt = $mysqli->prepare("SELECT emailadresse, passwort FROM benutzer WHERE emailadresse = ? AND  passwort = ? LIMIT 1");
            $stmt->bind_param('ss', $email, $hash);
            $stmt->execute();
            $stmt->bind_result($email, $hash);
            $stmt->store_result();

            //Wenn Kombination existiert
            if($stmt->num_rows == 1){

                //fetching des erfolgreichen Abfrage
                while($stmt->fetch()) {
                $_SESSION['Logged'] = 1;
                //Emailadresse des Nutzers wird in seiner Session gespeichert
                    $_SESSION['email'] = $email;
                    echo 'Erfolgreich angemeldet!';

                    //Wenn häkchen bei "angemeldet bleiben" gesetzt
                    if(isset($_POST['angemeldet_bleiben'])) {
                        //Emailadresse des Users wird in einem Cookie gespeichert
                        setcookie("email",$email,time()+(3600*24*365)); //1 Jahr Gültigkeit
                    }

                    //Benutzer wird nach erfolgreichem Login auf die Startseite weitergeleitet
                  header("Location: index.php");
                    exit();
                }

            }
            //Wenn die Kombination aus Benutzername und Passwort nicht existiert
            else {
                echo "<div class='form'><h3>Benutzername/Passwort ist nicht korrekt.</h3> <br/>Klicke hier um dich einzuloggen: <a href='login.php'>Login</a>";
            }
            //Schließen der Datebankverbindung
            $stmt->close();

        }
        else {

            $mysqli->close();


        ?>

        <?php
            //Überprüfe auf den 'Angemeldet bleiben'-Cookie
            if (isset($_COOKIE['email'])) {
             //Cookie wird der Variable $emailC zugeordnet
                $emailC = $_COOKIE['email'];
            } else {
                $emailC = "";
            }

?>

        <div class="form">
            <h1>Login</h1>
            <form action="" method="post" name="login">
                <!-- Falls Cookie exisitert, wird die Emailadresse beim naechsten Besuch automatisch in das Feld gesetzt -->
                <input type="email" value="<?php echo ($emailC); ?>" name="email" id="emaill" placeholder="E-Mailadresse" required />
                <br>
                <input type="password" name="passwort" id="passwortl" placeholder="Passwort" minlength="6" required />
                <br><a id="emaillabel">E-Mailadresse speichern?</a>
                <input type="checkbox" id = "emailSpeichern" name="angemeldet_bleiben" value="1"/><br>
                <input id="loginb" name="submit" type="submit" value="Login" />
            </form>

            <br />
            <p>Noch nicht registriert? <a href='registrieren.php'>Jetzt Registrieren</a></p>
            <br /><br />

        </div>
    <?php } ?>

</main>

<!-- Einbindung Footer mit include -->
<?php include ("footer.php"); ?>


</body>
</html>



