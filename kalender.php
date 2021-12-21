<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="all">
    <header class="site-header">
        <div class ="logout">
            <form method="post">
                <button id="logout" type="submit">Logout</button>
            </form>
        </div>

        <h1>
            Kalender
        </h1>
    </header>
    <hr>

    <nav class="site-nav">
        <ul class="site-nav-list">
            <li><a href="Start.php">Startseite</a></li>
            <li><a href="meeting.php">Meetings <!--Hier könnte noch eine weitere verschachtelte Liste eingefügt werden--></a></li>
            <li><a href="notiz.php">Notizen/Dokumente</a></li>
            <li><a href="mitteilung.php">Mitteilungen</a></li>
        </ul>

    </nav>
    <main class="site-content">
        <section class="content-sidebox">
            <article class="sidebox">
                <p><strong>Neue Datei hinzufügen</strong></p><br>
                <input type="text" placeholder="Muss noch geändert werden!" name="upload" id="upload"><br>
                <p><strong>Neues Ereignis eintragen</strong></p><br>
                <input type="date" name="date" id="date"><br>
                <input type="time" name="Uhrzeit" id="Uhrzeit"><br>
                <input type="text" placeholder="Beschreibung" name="Beschreibung" id="Beschreibung"><br>
                <input type="text" placeholder="Modul" name="Modul" id="Modul"><br>
                <input type="text" placeholder="Link" name="Link" id="Link"><br>
                <input type="checkbox"><strong>Wiederkehrendes Meeting</strong>
            </article>
        </section>
        <section class="content-kalender">

            <p>Plane deinen kompletten Alltag mit nur <strong>einer</strong> Anwendung!</p>
            <p><em>Module</em> anlegen, <em>Kalender</em> füllen, <em>Notizen</em> anlegen und alles <em>mit Freunden teilen</em></p>

            <!-- Das ist eine geordnete Liste mit Nummern statt Aufzählungspunkten
            <ol>
                <li>Modul anlegen</li>
                <li>Modul Meeting-Link und Zeiten zum Modul eintragen</li>
                <li>Notizen unter diesem Dokument ablegen</li>
            </ol>
            -->
        </section>



    </main>
    <footer class="site-footer">
        <a href="#top">Nach Oben!</a>
    </footer>
</div>
</body>
</html>

