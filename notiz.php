<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);
$modules = get_modules_as_array($user_data, $conn);

if (isset($_POST['notizabgeben']))
{
    $Nutzer_id = $user_data['id'];
    $titel = $_POST['notizname'];
    $inhalt = $_POST['notiztext'];
    $modul = $_POST['modul'];

    if (!empty($titel) && !empty($inhalt))
    {
        $sql = "insert into Notiz (name, text, Nutzer_id, modul_id) values ('$titel', '$inhalt', $Nutzer_id, '$modul')";
        $result = $conn->query($sql);
        header("location: notiz.php");
        die;
    }
}

if (isset($_POST['delete']))
{
    $Nutzer_id = $user_data['id'];
    $notiz = $_POST['badnote'];

    $sql = "delete from Notiz where id = '$notiz'";
    $conn->query($sql);

    header("Location: notiz.php");
    die;
}
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
            <?php echo $user_data['vorname'],'`s ';?>Notizen
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

        <div style="display: flex">
            <div class="meetings">
                <div id='accordeon'>
                    <?php show_user_notes($conn, $user_data);?>
                </div>
            </div>
        </div><br><br>

        <div class="neuenotiz">
            <form method="post">
                <input name="notizname" id="notizname" type="text" placeholder="Titel">
                <select name="modul" id="modul">
                    <?php
                    create_module_dropdown($modules);
                    ?>
                </select><br><br>
                <textarea name="notiztext" id="notiztext">
                </textarea><br>
                <button type="submit" id="notizabgeben" name="notizabgeben" placeholder="Notiz fertig!">Notiz fertig!</button><br><br>
            </form>
        </div>

        <div class="notizloeschen">
            <form method="post">
                <select name="badnote" id="badnote">
                    <?php
                    create_note_dropdown($conn, $user_data);
                    ?>
                </select>
                <button type="submit" name="delete" id="delete">Notiz löschen</button>
            </form>
        </div>

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
