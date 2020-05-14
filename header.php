<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */


/**
 * Bei verfügbarer Session soll der Login-Button ausgegraut werden, andernfalls der Logout-Button
 * String $disableLogout
 * String $disableLogin
 */
$disableLogout = "";
$disableLogin  = "";
session_start();

if (!isset($_SESSION['email'])) {
    $disableLogout = "disabled=disabled";
} else {
    $disableLogin = "disabled=disabled";
}
?>


<header>
    <a class='logo' id="logo" href="index.php"><img id="logo" src="img/datenbankenlogo.png" align=left width=10% alt="logo"></a>

    <nav>
        <ul id='menu'>
            <li><a href=index.php>Home</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn">Events</a>
                <div class="dropdown-content">
                    <a href=events.php>Eventübersicht</a>
                    <a href=eventFormular.php>Event anlegen</a>
                </div>
            </li>
            <li><a href=kontakt.php>Kontakt</a></li>
            <li><a href=meine_events.php>Meine Events</a></li>
            <li><form action="login.php">
                    <!-- Wenn Session mit email vorhanden ausgegraut -->
                    <input id="login" type="submit" value="Login"  <?php
                    echo $disableLogin;
                    ?> />
                </form>
            </li>
            <li><form action="logout.php">
                    <!-- Wenn Session mit email vorhanden nicht ausgegraut -->
                    <input id ="logout" type="submit" value="Logout"  <?php
                    echo $disableLogout;
                    ?> />
                </form>
            </li>
            <li>
                <form action="einstellungen.php">
                    <input id ="einstellungen" type="submit" value="Einstellungen"/>
                </form>
            </li>
        </ul>
    </nav>



</header>