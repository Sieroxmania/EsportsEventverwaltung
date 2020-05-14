/*Esports-Eventverwaltung
Author: Henrik Brauer
Funktion für das Überprüfen der eingaben im Login-Formular auf login.php
*/


/*
Fügt am anfang die EventListener zu den einzelnen Eingabefeldern für registrierung.php hinzu
 */
function initiate(){
    var y = document.getElementById('email');
    y.addEventListener('blur', checkval);
    var z = document.getElementById('passwort');
    z.addEventListener('blur', checkval);

}


/*
* Funktion, um Eingabefelder in Echtzeit zu prüfen und
* Felder farblich zu markieren, wenn Validierung fehlschlägt
* */
function checkval(e){
    var elem=e.target;

    /*Wenn Validierung fehlschlägt */
    if(elem.checkValidity()==false){
        elem.setAttribute('style','background: red');
        /*Wenn Validierung OK */
    }else{
        elem.setAttribute('style','background: green');
    }


}


window.onload=initiate;