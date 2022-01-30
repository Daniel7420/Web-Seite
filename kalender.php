<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);
$modules = get_modules_as_array($user_data, $conn);

if(isset($_POST['submit']))
{
    $date = $_POST['date'];
    $uhrzeitv = $_POST['uhrzeitv'];
    $uhrzeitb = $_POST['uhrzeitb'];
    $beschreibung = $_POST['beschreibung'];
    $modul = $_POST['modul'];
    $link = $_POST['link'];
    $nutzer = $user_data['id'];

    echo "$date, $uhrzeitv, $uhrzeitb, $modul, $nutzer";

    if(!empty($date) && !empty($uhrzeitv) && !empty($uhrzeitb) && !empty($beschreibung) && !empty($modul))
    {
        $query1 = "select * from Modul where name = '$modul' and Nutzer_id = '$nutzer'";
        $res1 = $conn->query($query1);
        #echo mysqli_num_rows($res1);

        if (mysqli_num_rows($res1) > 0)
        {
            $module_for_appointment = mysqli_fetch_assoc($res1);
            $modul_id = $module_for_appointment['id'];
            #echo "$modul_id";
            #echo "erfolgreich";
            if (empty($link))
            {
                $termin_link = $module_for_appointment['link'];
            }
            else
            {
                $termin_link = $link;
            }
            if (isset($_POST['wiederholung']))
            {
                $wholung = $_POST['repititiondropdown'];
                $until = $_POST['until'];
                $datum = $date;

                switch ($wholung)
                {
                    case 't':
                        while ($datum <= $until)
                        {
                            #Datenrechnung gefunden untr: https://stackoverflow.com/questions/3727615/adding-days-to-date-in-php

                            $query2 = "insert into Termin (Beschreibung, Datum, Zeitv, Zeitb, Modul_id, Nutzer_id, link) values ('$beschreibung', '$datum', '$uhrzeitv', '$uhrzeitb', '$modul_id', '$nutzer', '$termin_link')";
                            $result = $conn->query($query2);

                            $datum = date('Y-m-d', strtotime($datum. ' + 1 days'));
                        }
                    case 'w':
                        while ($datum <= $until)
                        {
                            $query2 = "insert into Termin (Beschreibung, Datum, Zeitv, Zeitb, Modul_id, Nutzer_id, link) values ('$beschreibung', '$datum', '$uhrzeitv', '$uhrzeitb', '$modul_id', '$nutzer', '$termin_link')";
                            $result = $conn->query($query2);

                            $datum = date('Y-m-d', strtotime($datum. ' + 7 days'));
                        }
                    case 'm':
                        while ($datum <= $until)
                        {
                            $query2 = "insert into Termin (Beschreibung, Datum, Zeitv, Zeitb, Modul_id, Nutzer_id, link) values ('$beschreibung', '$datum', '$uhrzeitv', '$uhrzeitb', '$modul_id', '$nutzer', '$termin_link')";
                            $result = $conn->query($query2);

                            $datum = date('Y-m-d', strtotime($datum. ' + 28 days'));
                        }

                    case 'j':
                        while ($datum <= $until)
                        {
                            $query2 = "insert into Termin (Beschreibung, Datum, Zeitv, Zeitb, Modul_id, Nutzer_id, link) values ('$beschreibung', '$datum', '$uhrzeitv', '$uhrzeitb', '$modul_id', '$nutzer', '$termin_link')";
                            $result = $conn->query($query2);

                            $datum = date('Y-m-d', strtotime($datum. ' + 365 days'));
                        }
                }
            }
            else
            {
                $query2 = "insert into Termin (Beschreibung, Datum, Zeitv, Zeitb, Modul_id, Nutzer_id, link) values ('$beschreibung', '$date', '$uhrzeitv', '$uhrzeitb', '$modul_id', '$nutzer', '$termin_link')";
                $result = $conn->query($query2);

            }


            }



        }
    else{
        echo "Kein Eintrag vorhanden!";

    }
    # https://www.youtube.com/watch?v=yNolUEBE3Wc --> creating an array

    header("Location: kalender.php");
    die;
    #https://stackoverflow.com/questions/25462367/whenever-i-reload-refresh-my-page-it-doubles-the-mysql-query-php
}

if (isset($_POST['del']))
{
    $Nutzer_id = $user_data['id'];
    echo $termin = $_POST['badapp'];

    $sql = "delete from Termin where Termin_id = '$termin'";
    $conn->query($sql);

    header("Location: kalender.php");
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="style.css" rel="stylesheet">
    <script src="jquery-3.6.0.js" defer></script>
    <script src="Methods.js" defer></script>
</head>
<body class="all">
<header class="site-header">
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
    <h1>
        <?php echo $user_data['vorname'],'`s ';?>Termine
    </h1>
    <h2>
        All in one for every Student
    </h2>
</header>
<hr>

<nav class="site-nav">
    <ul class="site-nav-list">
        <li><a href="index.php">Startseite</a></li>
        <li><a href="kalender.php">Kalender</a></li>
        <li><a href="meeting.php">Module <!--Hier könnte noch eine weitere verschachtelte Liste eingefügt werden--></a></li>
        <li><a href="notiz.php">Notizen/Dokumente</a></li>
    </ul>

</nav>


<main class="site-content">
    <form method="post">
    <p><strong>Neue Datei hinzufügen</strong></p><br>
    <input type="file" placeholder="ICS Datei hochladen" name="upload" id="upload"><br>
    <p><strong>Neues Ereignis eintragen</strong></p><br>
    <input type="date" name="date" id="date"><br><br>
    <input type="time" placeholder="von" name="uhrzeitv" id="uhrzeitv"><br><br>
    <input type="time" placeholder="bis" name="uhrzeitb" id="uhrzeitb"><br><br>
    <input type="text" placeholder="beschreibung" name="beschreibung" id="beschreibung"><br><br>
    <select name="modul", id="modul">
        <?php
        create_module_dropdown($modules);
        ?>
    </select><br><br>
    <!--<input type="text" placeholder="modul" name="modul" id="modul"><br><br>-->
    <input type="text" placeholder="link" name="link" id="link"><br><br><br>

    <input type="checkbox" id="wiederholung" name="wiederholung"><strong>Wiederkehrend</strong><br><br>
    <label for="wiederholung">Wiederkehrend</label><br>
    <select name="repititiondropdown", id="repititiondropdown">
        <option value="t">Täglich</option>
        <option value="w">Wöchentlich</option>
        <option value="m">Monatliche</option>
        <option value="j">Jährlich</option>
    </select><br><br>
    <input type="date" name="until"><br><br>

        <button type="submit" class="button standard" name="submit" id="submit">Termin hinzufügen</button><br><br>
    </form>

    <div class="terminloeschen">
        <form method="post">
            <select name="badapp" id="badapp">
                <?php
                create_appointment_dropdown($conn, $user_data);
                ?>
            </select>
            <button type="submit" name="del" id="del">Termin löschen</button>
        </form>
    </div>
</main>
<footer class="site-footer">
    <a href="#top">Nach Oben!</a>
</footer>

</body>
</html>

