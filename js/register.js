/*Esports-Eventverwaltung
Author: Henrik Brauer
Funktion für das Überprüfen der eingaben im Registrierungs-Formular auf registrierung.php
*/


/*
Fügt am anfang die EventListener zu den einzelnen Eingabefeldern für registrierung.php hinzu
initiate() dient dem Setzen von Eventlistenern, die zu Beginn gebraucht werden, um in Echtzeit die Nutzereingabe zu prüfen;
 */
function initiate(){
         var y = document.getElementById('emailadresse');
 y.addEventListener('blur', checkval);       
		var x = document.getElementById('benutzername');
 x.addEventListener('blur', checkval);
        var z = document.getElementById('passwort');
 z.addEventListener('blur', checkval);
       var a = document.getElementById('passwortw');
 a.addEventListener('blur', checkval);
    }
	
	
    /*
    * Funktion, um Eingabefelder in Echtzeit zu prüfen und
    * Felder farblich zu markieren, wenn Validierung fehlschlägt
    * */
    function checkval(e){
        var elem=e.target;

        /*Wenn Validierung fehlschlägt */
     if(elem.checkValidity()==false){
  elem.setAttribute('style','background: red'); /*Setzte Hintergrund auf rot*/
        }else{  /*Wenn Validierung OK */
  elem.setAttribute('style','background: green');/*Setzte Hintergrund auf grün*/
        }
    }

    /*
    * Funktion, die auf den Button-Klick reagiert.
    * Sie prüft zunächst das Formular auf Validität.
    */
function checkform(e) {
    //Prüfen des Formulars mit checkValidity()
    //var a=document.getElementById("submit");
    var b=document.getElementById("registration");
    //Wenn Validierung OK
    if(b.checkValidity()==true){

        var pw1=document.getElementById('passwort').value;
        var pw2=document.getElementById("passwortw").value;

        //Prüft ob die Passwörter übereinstimmen
        if (pw1==pw2) {
            identical = true;

            console.log("Passwörter stimmen überein");
            //a.submit();
           // document.getElementById("btnSubmit").submit();
            document.Registration.submit();

        } else {    //Wenn Validierung OK, wird das Formular abgesendet

            console.log("Passwörter stimmen nicht überein");
        }
    }
}


window.onload=initiate;