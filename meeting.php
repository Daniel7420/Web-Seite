<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);
$user_modul = getMoudul($conn, $user_data);

if(isset($_POST['sub']))
{
    $modul = $_POST['modul'];
    $desc = $_POST['descr'];
    $link = $_POST['link'];

    if(!empty($modul) && !empty($desc) && !empty($link))
    {
        $sql = "select * from Modul where name = '$modul'";
        $res = $conn->query($sql);

        if($res && mysqli_num_rows($res) > 0)
        {
            echo "modul schon vorhanden";
        }
        else
        {
            $user_id = $user_data['id'];
            $query = "insert into Modul (name, beschreibung, link, Nutzer_id) values ('$modul', '$desc', '$link', '$user_id')";
            $conn->query($query);
            echo "Modul angelegt.";
        }
    }
    else
    {
        echo "bitte alle Felder ausfüllen";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meeting</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="all">
    <div class ="logout">
        <form method="post">
            <button id="logout" name="logout" type="submit">Logout</button>
        </form>
    </div>
    <?php
    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: logout.php');
    }
    ?>
    <hr>
    <nav class="site-nav">
        <ul class="site-nav-list">
            <li><a href="Start.php">Startseite</a></li>
            <li><a href="kalender.php">Kalender</a></li>
            <li><a href="notiz.php">Notizen/Dokumente</a></li>
            <li><a href="mitteilung.php">Mitteilungen</a></li>
        </ul>

    </nav>

    <header class="site-header">

        <h1>
            Module
        </h1>
    </header>

    <main class="site-content">

        <div style="display: flex">

            <div class="meetings">
                <div id="accordeon">
                <?php show_user_meetings($conn, $user_data, $user_modul);?>
                </div>
            </div>

            <section class="content-sidebox">

                <h3>Modul</h3>
                <form method="post">
                    <input type="text" placeholder="Modulname" name="modul" id="modul"><br><br>
                    <input type="text" placeholder="Beschreibung" name="descr" id="descr"><br><br>
                    <input type="text" placeholder="Link der Veranstaltung" name="link" id="link"><br><br>
                    <button class="button standard">Hochladen</button>
                </form>
            </section>
        </div>

        <!-- Das ist eine geordnete Liste mit Nummern statt Aufzählungspunkten
        <ol>
            <li>Modul anlegen</li>
            <li>Modul Meeting-Link und Zeiten zum Modul eintragen</li>
            <li>Notizen unter diesem Dokument ablegen</li>
        </ol>
        -->

    </main>
    <!--
    So werden beim Hovern über den jeweiligen Paragraphen Infos angezeigt!
    <p title="Infos"> Infos</p>
    -->


    <footer class="site-footer">
        <!--    href="#" heißt, dass das Sprungziel auf der selben Seite ist.
                In HTML 5 ist definiert, dass man sich die ID bei der Dokumenten-Angabe sparen, und stattdessen den Befehel #Top verwenden-->
        <a href="#top">Nach Oben</a>
    </footer>
</div>
</body>
</html>

