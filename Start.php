<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);
$user_appointment = getNextMeeting($conn, $user_data);
$user_nextMeeting = processNextMeeting($conn, $user_appointment);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        StudyPlanner
    </title>
    <meta name="description" content="Der einfachste Uni-Planer für jeden Study">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- 'Optimiert' die Seite für mobile Geräte. "initial-scale" & "shrink-to-fit" sind explizit für den safari browser-->
    <link href="style.css" rel="stylesheet">
</head>
<div>
    <div class="all"
    <header class="site-header">
        <div class ="logout">
            <form method="post">
                <button id="logout" type="submit">Logout</button>
            </form>
        </div>
        <?php
        if(isset($_POST['logout'])){
            session_destroy();
            header('Location: Login.php');
        }
        ?>
        <h1>
            <?php echo $user_data['vorname'],'`s ';?>Planner-
        </h1>
        <h2>
            All in one for every Student
        </h2>
    </header>
    <nav class="site-nav">
        <ul class="site-nav-list">
            <li><a href="Start.php">Startseite</a></li>
            <li><a href="kalender.php">Kalender</a></li>
            <li><a href="meeting.php">Meetings <!--Hier könnte noch eine weitere verschachtelte Liste eingefügt werden--></a></li>
            <li><a href="notiz.php">Notizen/Dokumente</a></li>
            <li><a href="mitteilung.php">Mitteilungen</a></li>
        </ul>

    </nav>
    <hr>
    <main class="site-content">
        <section class="content-kalender">

            <table class="stundenplan">
                <thead class="tablehead">
                <tr>
                    <th>MONTAG</th>
                    <th>DIENSTAG</th>
                    <th>MITTWOCH</th>
                    <th>DONNERSTAG</th>
                    <th>FREITAG</th>
                    <th>SAMSTAG</th>
                    <th>SONNTAG</th>
                </tr>
                </thead>
                <tbody class="tablebody">
                <tr>
                    <td>Zeile 1, Spalte 1</td>
                    <td>Zeile 1, Spalte 2</td>
                    <td>Zeile 1, Spalte 3</td>
                    <td>Zeile 1, Spalte 4</td>
                    <td>Zeile 1, Spalte 5</td>
                    <td>Zeile 1, Spalte 6</td>
                    <td>Zeile 1, Spalte 7</td>
                </tr>
                </tbody>
                <tfoot class="tablefooter">
                <tr>
                    <td colespan="7">die Tabellen Fußzeile geht über alle spalten</td>
                </tr>
                </tfoot>
            </table>
        </section>
        <section class="sidebox">
            <article class="next_meeting">

                <h3>Nächstes Meeting</h3>
                <p> <?php echo $user_data['name'], ', ';?></p> <br>
                <p> <?php echo $user_nextMeeting;?></p> <br>
                <a href="
                    <?php
                $modul_id = $user_appointment['Modul_id'];
                $sql = "select link from Modul where id = $modul_id";
                $result = $conn->query($sql);
                $link = mysqli_fetch_assoc($result);
                echo $link['link'];
                ?>"
                >Zum Meeting!
                </a>




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
