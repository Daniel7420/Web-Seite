<?php
session_start();

include('connection.php');
include('functions.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $mail = $_POST['mail'];
    $passwort = $_POST['passwort'];
    $name = $_POST['name'];

    if(!empty($mail) && !empty($passwort)){
        $sql = "insert into Nutzer (name, mail, passwort) values ('$name', '$mail', '$passwort')";

        $conn->query($sql);

        header("Location: Login.php");
        die;
    }
    else{
        echo "Bitte gültige Daten eingeben";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Registrieren
    </title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="all">
    <header class="site-header">
        <h1 class="head1">
            Willkommen auf
        </h1>
        <h2 class="head2">
            MyStudyPlanner
        </h2>
    </header>
    <section>
        <!-- Aufbau orientiert an vergangenem Projekt-->
        <div class="container" id="box">
            <form method="post">
                <div style="font-size: 20px; margin: 10px; color: darkslategrey;">Registrieren</div>
                <input type="text" placeholder="Benutzername" name="mail" id="mail"><br>
                <input type="password" placeholder="Passwort" name="passwort" id="passwort"><br>
                <input type="name" placeholder="Name" name="name" id="name"><br>
                <input type="submit" name="registrieren" value="registrieren">

                <a href="Login.php">Login</a>
            </form>
        </div>

    </section>
</div>
</body>
</html>



