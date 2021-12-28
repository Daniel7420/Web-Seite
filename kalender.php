<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);

if(isset($_POST['submit']))
{
    $date = $_POST['date'];
    $uhrzeitv = $_POST['uhrzeitv'];
    $uhrzeitb = $_POST['uhrzeitb'];
    $beschreibung = $_POST['beschreibung'];
    $modul = $_POST['modul'];
    $link = $_POST['link'];
    $nutzer = $user_data['id'];

    echo "$date, $uhrzeitv, $uhrzeitb, $modul, $nutzer ";

    if(!empty($date) && !empty($uhrzeitv) && !empty($uhrzeitb) && !empty($beschreibung) && !empty($modul))
    {
        echo "felder ausgefüllt ";
        $query1 = "select * from Modul where name = '$modul' and Nutzer_id = '$nutzer'";
        $res1 = $conn->query($query1);
        #echo mysqli_num_rows($res1);

        if (mysqli_num_rows($res1) > 0)
        {
            $module_for_appointment = mysqli_fetch_assoc($res1);
            $modul_id = $module_for_appointment['id'];
            echo "$modul_id";
            echo "erfolgreich";

            $sql = "insert into Termin (Beschreibung, Datum, Zeitv, Zeitb, Modul_id, Nutzer_id) values ('$beschreibung', '$date', '$uhrzeitv', '$uhrzeitb', '$$modul_id', '$nutzer')";
            mysqli_query($conn, $sql);
        }

        }
    else{
        echo "Kein Eintrag vorhanden!";

    }
}
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
            <form method="post">
                <article class="sidebox">
                    <p><strong>Neue Datei hinzufügen</strong></p><br>
                    <input type="text" placeholder="ICS Datei hochladen" name="upload" id="upload"><br>
                    <p><strong>Neues Ereignis eintragen</strong></p><br>
                    <input type="date" name="date" id="date"><br><br>
                    <input type="time" placeholder="von" name="uhrzeitv" id="uhrzeitv"><br><br>
                    <input type="time" placeholder="bis" name="uhrzeitb" id="uhrzeitb"><br><br>
                    <input type="text" placeholder="beschreibung" name="beschreibung" id="beschreibung"><br><br>
                    <input type="text" placeholder="modul" name="modul" id="modul"><br><br>
                    <input type="text" placeholder="link" name="link" id="link"><br><br>
                    <input type="checkbox"><strong>Wiederkehrendes Meeting</strong><br>
                    <button type="submit" placeholder="Zum Kalender hinzufügen" name="submit" id="submit"><br><br>
                </article>
            </form>
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

