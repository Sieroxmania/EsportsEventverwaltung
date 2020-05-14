<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */



/**Wir nach dem laden der Seite ausgeführt, bedingt durch die Weiterleitung durch 'eventAuswahl'
 * Holt saemtliche Informatioen zu der ausgewählten Veranstaltung aus der Datebank und speichert diese
 * in Variablen, damit diese anschließend in die Form geschrieben werden können.
 * String $eventId ausgewählter Eventname, vom Event, dass gemeldet werden soll
 * String $result ergebnisse des Datenbank-querys
 * Integer $id ID des Events
 * String $eventname Eventname, gleichbleibend mit $eventId
 * @param $abfrage SQL-Query
 */
function erstelleJson($abfrage) {
    global $mysqli;
    require('db_connect.php');

    $stmt = $mysqli->prepare("$abfrage");
    $stmt->execute();

    //Wenn mindestens ein Ergebniss mit dem Query erzielt wurden
    if ($stmt->execute()) {

        /* bind result variables */
        $stmt->bind_result($id_event,$eventname, $spielname, $datum, $teilnehmeranzahl, $veranstalterverweis, $preigeld, $ort, $gewinner, $plattform);
        $stmt->store_result();
    }
    if ($stmt->num_rows >0 ){

        /* fetch values */
        while ($stmt->fetch()) {
            $output[]=array("eventid" => $id_event, "Eventname" => $eventname, "Spielname" => $spielname, "Datum" =>$datum, "Teilnehmeranzahl" => $teilnehmeranzahl, "Veranstalter" => $veranstalterverweis,"Preisgeld" => $preigeld,"Ort" => $ort,"Gewinner" => $gewinner, "Plattform" =>$plattform);
        }
        //Überträgt Arrays in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, json_encode($output));
        fclose($fp);
        $bool = "true";
        return $bool;

        //Wenn keine Ergbenisse erzielt worden
    } else {
        //Erstellt ein Array in der Datei "allEvents.json"
        $output = "[{\"Eventübersicht\":\"No Data available\",\"Eventübersicht\":\"No Data available\",\"spielname\": \"\",\"datum\":\"\",\"teilnehmeranzahl\":\"\",\"veranstalterverweis\":\"\",\"preisgeld\":\"\",\"ort\":\"\",\"gewinner\":\"\",\"plattform\":\"\"}]";

        //Schreibt das Array in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, ($output));
        fclose($fp);
        $bool = "false";
        return $bool;
    }
}


/**Wir nach dem laden der Seite ausgeführt, bedingt durch die Weiterleitung durch 'eventAuswahl'
 * Holt saemtliche Informatioen zu der ausgewählten Veranstaltung aus der Datebank und speichert diese
 * in Variablen, damit diese anschließend in die Form geschrieben werden können.
 * String $eventId ausgewählter Eventname, vom Event, dass gemeldet werden soll
 * String $result ergebnisse des Datenbank-querys
 * Integer $id ID des Events
 * String $eventname Eventname, gleichbleibend mit $eventId
 * @param $abfrage SQL Query
 * @param $var1 Bedingung für $abfrage
 */
function erstelleJsonVar($abfrage, $var1) {
    global $mysqli;
    require('db_connect.php');

    $stmt = $mysqli->prepare($abfrage);
    $stmt->bind_param('s', $var1);
    $stmt->execute();

   if ($stmt->execute()) {
       /* bind result variables */
       $stmt->bind_result($id_event, $eventname, $spielname, $datum, $teilnehmeranzahl, $veranstalterverweis, $preigeld, $ort, $gewinner, $plattform);
       $stmt->store_result();
   }
    //Wenn mindestens ein Ergebniss mit dem Query erzielt wurden
       if ($stmt->num_rows >0 ){

    /* fetch values */
    while ($stmt->fetch()) {
        $output[]=array("eventid" => $id_event, "Eventname" => $eventname, "Spielname" => $spielname, "Datum" =>$datum, "Teilnehmeranzahl" => $teilnehmeranzahl, "Veranstalter" => $veranstalterverweis,"Preisgeld" => $preigeld,"Ort" => $ort,"Gewinner" => $gewinner, "Plattform" =>$plattform);
    }
        //Überträgt Arrays in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, json_encode($output));
        fclose($fp);
        $bool = "true";
        return $bool;
        //Wenn keine Ergbenisse erzielt worden
    } else {
        //Erstellt ein Array in der Datei "allEvents.json"
        $output = "[{\"Eventübersicht\":\"No Data available\",\"spielname\": \"\",\"datum\":\"\",\"teilnehmeranzahl\":\"\",\"veranstalterverweis\":\"\",\"preisgeld\":\"\",\"ort\":\"\",\"gewinner\":\"\",\"plattform\":\"\"}]";

        //Schreibt das Array in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, ($output));
        fclose($fp);
           $bool = "false";
           return $bool;
    }
}


/**Wir nach dem laden der Seite ausgeführt, bedingt durch die Weiterleitung durch 'eventAuswahl'
 * Holt saemtliche Informatioen zu der ausgewählten Veranstaltung aus der Datebank und speichert diese
 * in Variablen, damit diese anschließend in die Form geschrieben werden können.
 * String $eventId ausgewählter Eventname, vom Event, dass gemeldet werden soll
 * String $result ergebnisse des Datenbank-querys
 * Integer $id ID des Events
 * String $eventname Eventname, gleichbleibend mit $eventId
 * @param $abfrage SQL Query
 */
function erstelleJsonHome($abfrage) {
    global $mysqli;
    require('db_connect.php');

    $sql = $abfrage;

    $query = $mysqli->query($sql);

    //Wenn mindestens ein Ergebniss mit dem Query erzielt wurden
    if ($query->num_rows > 0) {

        //Fetch $result in Array
        while ($row = $query->fetch_assoc()) {
            $output[] = $row;
        }

        //Überträgt Arrays in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, json_encode($output));
        fclose($fp);

        //Wenn keine Ergbenisse erzielt worden
    } else {
        //Erstellt ein Array in der Datei "allEvents.json"
        $output = "[{\"Eventübersicht\":\"No Data available\",\"Eventübersicht\":\"No Data available\",\"spielname\": \"\"}]";

        //Schreibt das Array in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, ($output));
        fclose($fp);
    }


}

/**Wir nach dem laden der Seite ausgeführt, bedingt durch die Weiterleitung durch 'eventAuswahl'
 * Holt saemtliche Informatioen zu der ausgewählten Veranstaltung aus der Datebank und speichert diese
 * in Variablen, damit diese anschließend in die Form geschrieben werden können.
 * String $eventId ausgewählter Eventname, vom Event, dass gemeldet werden soll
 * String $result ergebnisse des Datenbank-querys
 * Integer $id ID des Events
 * String $eventname Eventname, gleichbleibend mit $eventId
 * @param $abfrage SQL Query
 * @param $var1 Bedingung für $abfrage
 */
function erstelleJsonLike($abfrage, $var1) {
    global $mysqli;
    require('db_connect.php');
    $eingabe = "%$var1%";

    $stmt = $mysqli->prepare("$abfrage");
    $stmt->bind_param('s', $eingabe);
    $stmt->execute();

    // $arr = array();
    //Wenn mindestens ein Ergebniss mit dem Query erzielt wurden
    if ($stmt->execute()) {

        /* bind result variables */
        $stmt->bind_result($id_event, $eventname, $spielname, $datum, $teilnehmeranzahl, $veranstalterverweis, $preigeld, $ort, $gewinner, $plattform);
        $stmt->store_result();
    }
    if ($stmt->num_rows >0 ){

        /* fetch values */
        while ($stmt->fetch()) {
            $output[]=array("eventid" => $id_event, "Eventname" => $eventname, "Spielname" => $spielname, "Datum" =>$datum, "Teilnehmeranzahl" => $teilnehmeranzahl, "Veranstalter" => $veranstalterverweis,"Preisgeld" => $preigeld,"Ort" => $ort,"Gewinner" => $gewinner, "Plattform" =>$plattform);
        }
        //Überträgt Arrays in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, json_encode($output));
        fclose($fp);
        $bool = "true";
        return $bool;

        //Wenn keine Ergbenisse erzielt worden
    } else {
        //Erstellt ein Array in der Datei "allEvents.json"
        $output = "[{\"Eventübersicht\":\"No Data available\",\"spielname\": \"\",\"datum\":\"\",\"teilnehmeranzahl\":\"\",\"veranstalterverweis\":\"\",\"preisgeld\":\"\",\"ort\":\"\",\"gewinner\":\"\",\"plattform\":\"\"}]";

        //Schreibt das Array in die Datei "allEvents.json"
        $fp = fopen('allEvents.json', 'w');
        fwrite($fp, ($output));
        fclose($fp);
        $bool = "false";
        return $bool;
    }
}