<?php /** @noinspection SpellCheckingInspection */
session_start();

include('connection.php');
include('functions.php');


$conn->set_charset("utf8");

if(isset($_POST['login'])){
    $mail = $_POST['mail'];
    $passwort = $_POST['passwort'];

    $sql = "SELECT * FROM Nutzer WHERE mail='$mail' AND passwort='$passwort'";
    $result = $conn->query($sql);

    if($result && mysqli_num_rows($result) > 0) {

        $user_data = mysqli_fetch_assoc($result);
        #https://www.geeksforgeeks.org/how-to-display-logged-in-user-information-in-php/

        if($user_data['passwort'] == $passwort){
            $_SESSION['mail'] = $user_data['mail'];
            header("Location: Start.php");
            die;
        }
    }

    else {
        echo "Benutzername, oder Passwort ist nicht bekannt";
    }
}
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Anmelden
    </title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<section class="all">
    <header class="site-header">
        <h1 class="head1">
            Willkommen auf
        </h1>
        <h2 class="head2">
            MyStudyPlanner
        </h2>
    </header>
    <main class="site-content">

        <section class="enter">
            <!-- Aufbau orientiert an vergangenem Projekt-->
            <div class ="container">
                <form method="post">
                    <div style="font-size: 30px; margin: 10px; color: darkslategrey;">Login</div>

                    <input type="text" placeholder="Bitte Benutzernamen eingeben" name="mail" id="mail"><br><br>
                    <input type="password" placeholder="Bitte Passwort eingeben" name="passwort" id="passwort"><br><br>

                    <button type="submit" id="login" name="login">Login</button><br><br>
                    <a href="signup.php">Kein Account?</a>
                </form>
            </div>

        </section>
        <aside class="beschreibung">
            <section>
                <h3>Das erwartet dich:</h3>
                <p>
                    ...
                </p>
            </section>
        </aside>
    </main>
</section>
</body>
</html>