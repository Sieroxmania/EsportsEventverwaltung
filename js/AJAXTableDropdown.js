/*Esports-Eventverwaltung
Author: Henrik Brauer
Klasse für das dynamische Erstellen von Tabellen mit Ajax aus einer JSON-Datei heraus und
für das Erstellen und anzeigen von Dropdown-Elementen, auch aus der JSON-Datei.
*/

/*
Funktion für das erstellen von dynamischen Tabellen mit den Einträgen aus der Datei allEvents.json
var tableData Daten aus der JSON Datei mit .responseText
var col Array für die cols
var table Element Table, was dargestellt werden soll
var tr table row
var th table header
var divContainer für das spätere einfügen des tables
@param -
*/
var getTableDataAJAX = function() {

    var getTableData = new XMLHttpRequest();

    getTableData.onreadystatechange = function() {
        if(getTableData.readyState === 4) {
            var tableData     = JSON.parse(getTableData.responseText);

            // Values für den Header aus der JSON-Datei herausziehen
            var col = [];
            for (var i = 0; i < tableData.length; i++) {
                for (var key in tableData[i]) {
                    if (col.indexOf(key) === -1) {
                        col.push(key);
                    }
                }
            }

            //Dynamische Tabelle erstellen
            var table = document.createElement("table");

            //Mit den Values für den Header wird die Header Row erstellt
            var tr = table.insertRow(-1);                   //Table row

            //Beginnend ab 1, damit die id's nicht mit angezeigt werden
            for (var i = 1; i < col.length; i++) {
                var th = document.createElement("th");      //Table header.
                th.innerHTML = col[i];
                tr.appendChild(th);
            }

            // Die restlichen Daten aus der Json-Datei benutzen
            for (var i = 0; i < tableData.length; i++) {

                tr = table.insertRow(-1);

                //Beginnend ab 1, damit die id's nicht mit angezeigt werden
                for (var j = 1; j < col.length; j++) {
                    var tabCell = tr.insertCell(-1);
                    tabCell.innerHTML = tableData[i][col[j]];
                }
            }

            //Als letztes wird die erstelle Tabelle, mit Inhalt, im Container "ajaxTable" dargestellt
            var divContainer = document.getElementById("ajaxTable");
            divContainer.innerHTML = "";

            divContainer.appendChild(table);



        };
    };
    getTableData.open("GET", "allEvents.json", true);
    getTableData.send();
};

var wrapperDiv = document.querySelector('div');
var AJAXbutton = document.getElementById('ajaxTable');



/*
Funktion für das erstellen von dynamischen dropdown / Option-Elementen mit den Einträgen aus der Datei allEvents.json
var dropdown aufrufen des Elements event-dropdown
const request neuer XMLHttpRequest
const data Daten aus der JSON Datei mit .responseText
option Element das später dargestellt werden soll, wird zum dropdown geaddet
@param -
*/
function erstelleAuswahl() {

    var dropdown = document.getElementById('event-dropdown');
    dropdown.length = 0;
    dropdown.selectedIndex = 0;

    const request = new XMLHttpRequest();
    request.open("GET", "allEvents.json", true);

    request.onload = function () {
        if (request.status === 200) {
            const data = JSON.parse(request.responseText);
            var option;
            for (var i = 0; i < data.length; i++) {
                option = document.createElement('option');
                option.text = data[i].Eventname;
                option.value = data[i].eventid;
                dropdown.add(option);
            }
        } else {

        }
    }

    request.onerror = function () {
        console.error('An error occurred fetching the JSON from ' + url);
    };

    request.send();
}
