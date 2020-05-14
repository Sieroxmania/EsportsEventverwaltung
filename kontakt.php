<?php
/**
 * Esports-Eventverwaltung
 * @Author Henrik Brauer
 */
?>


<html>
<head>
    <title>Kontakt</title>
    <!-- Einbindung css, js -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/gmap.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7ockDUB2sK-r4VPT6_KgFSwAJOihBc4&callback=initMap" async defer></script>
</head>

<body>

<!-- Einbindung Header mit include -->
<?php
include("header.php");
?>


<main>
    <h1>Kontakt</h1>
    <section>
        <article>
            <h2>Kontaktdetails</h2>
            <br /><p> <strong>Esports-Eventverwaltung</p>
            <p>Henrik Brauer </p>
            <p>Pascal Schmüser </strong></p>
            <p>23562 Lübeck</p>
        </article>
    </section>

    <section>
        <article>
            <h2>Inhaber</h2>
            <br><p> <strong>Henrik Brauer & Pascal Schmüser</strong></p>
            <p><a>Telefon:0 4561 / 11 11 11</a></p>
            <p><a>Mobil:0 160 / 1111 111 11</a></p>
            <p><a>E-mail:info@esportseventverwaltung.de</a></p>
        </article>
    </section>

    <section>
        <h2>Kontaktformular</h2>
        <br>
        <form id="kontaktformular" name="kontaktformular" action="">
            <div>
                <label for="absender">Ihre E-Mail-Adresse:<br></label>
                <input type="text" id="absender" name="absender" size="71" />
            </div>
            <div>
                <br /><p><label for="nachricht">Ihre Nachricht:<br></label></p>
                <textarea id="nachricht" name="nachricht" cols="50" rows="7"></textarea>
            </div>
            <div>
                <br /><input type="button" value="Abschicken" href="#"/>
            </div>
        </form>
    </section>

    <section>
        <h2>Anfahrt</h2>
        <!-- div für das Einbinden von Google Maps -->
        <div id="map"></div>
    </section>

</main>

<!-- Einbindung Footer mit include -->
<?php
include("footer.php");
?>


</body>

</html>