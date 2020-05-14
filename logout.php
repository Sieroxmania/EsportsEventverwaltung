<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */

//Wird beim klicken auf den Logout-Button in dem Header aufgerufen
//Session muss gestartet werden
session_start();
//Session wird rausgenommen und geloescht
unset($_SESSION);
session_destroy();
session_write_close();
//Anschließend wird der User auf die Startseite weitergeleitet
header("Location: index.php");
exit();
?>


