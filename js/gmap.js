/*Esports-Eventverwaltung
Author: Henrik Brauer
Funktion für das einbetten und darstellen von Google Maps
*/

var map;
function initMap() {
    var uluru = {lat: 53.837202, lng: 10.700384};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map
    });
}