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
    <title>Notizen</title>
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
            <li><a href="meeting.php">Meetings <!--Hier könnte noch eine weitere verschachtelte Liste eingefügt werden--></a></li>
            <li><a href="notiz.php">Notizen/Dokumente</a></li>
            <li><a href="mitteilung.php">Mitteilungen</a></li>
        </ul>

    </nav>

    <header class="site-header">

        <h1>
            Notizen
        </h1>
    </header>

    <main class="site-content">
        <section class="sidebox">
            <article class="sidebox">
                <h3>Dokumente</h3>
                <p>Item One (PHP Get)</p>
                <p>Item Two (PHP Get)</p>
                <p>Item Three (PHP Get)</p>
                <hr>
            </article>
            <article class="sidebox">
                <button type="submit" name="upload" id="upload">Datei hochladen</button>
            </article>
        </section>

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
