<?php /** @noinspection SpellCheckingInspection */

function check_login($conn){
    # Tutorial: https://www.youtube.com/watch?v=WYufSGgaCZ8
    if(isset($_SESSION['mail'])){
        $id = $_SESSION['mail'];
        $query = "select * from Nutzer where mail = '$id'";

        $result = mysqli_query($conn,$query);
        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    //Wenn das nicht funktioniert, gehe zum login
    header("Location: Login.php");
    die;
}

function getMoudul ($conn, $user_data)
{
    if(isset($user_data['id']))
    {
        $id = $user_data['id'];
        $sql = "select * from Modul where Nutzer_id = $id";
        $result = $conn->query($sql);

        $user_modul = mysqli_fetch_assoc($result);
        return $user_modul;
    }
}

function processNextMeeting($conn, $user_appointment)
{
    if(isset($user_appointment['Termin_id']))
    {
        $Modul_id = $user_appointment['Modul_id'];
        $sql = "select * from Modul where id = '$Modul_id'";
        $res = $conn->query($sql);
        $user_linkName = mysqli_fetch_assoc($res);
        //$link = $user_linkName['link'];
        $name = $user_linkName['name'];
        $zeit = $user_appointment['Zeitv'];
        return $text1 = "$name steht um $zeit an, beeil dich!";
    }
    return $text = "Für heute bist du durch mit den Meetings";
    die;

}
function getNextMeeting($conn, $user_data){
    if(isset($user_data['id'])){
        $id = $user_data['id'];
        $current_date = date('Y-m-d', time());
        echo $current_date;
        $sql = "select * from Termin where Nutzer_id = '$id' and Datum = '$current_date'";
        $result = $conn->query($sql);

        if($result && mysqli_num_rows($result) > 0){
            $user_appointment = mysqli_fetch_assoc($result);
            return $user_appointment;
        }
        else{
            return $text = "Kein anstehendes Meeting heute";
        }
    }
    die;
}
/*
function next_meeting($conn){
    #if(isset($_SESSION['id'])){
    #   $id = $_SESSION['id'];
    $sql = "select * from Termin where nutzer_id = '1'";
    $result = $conn->query($sql);
    return $result;
}
*/
function build_calendar ($conn){

    $id = $_SESSION['id'];
    $sql = "select * from Nutzer where 'id' = $id";
    $result = $conn-->query($sql);

    if (mysqli_num_rows($result) == 1){

    }
}

function show_user_meetings($conn, $user_data, $user_modul) // unsterstützt anhand der Anleitung von Stackoverflow: https://stackoverflow.com/questions/33331430/php-list-users-from-sql-database-in-table
{
    if(isset($user_data['id']))
    {
        $id = $user_data['id'];
        $modul = $user_modul['id'];
        $sql = "select * from Termin where Modul_id = '$modul' and Nutzer_id = '$id'";
        $res = $conn->query($sql);
        if (mysqli_num_rows($res) == 0)
        {
            $text = "Noch keine Einträge vorgeenommen";
            return $text;
        }
        else
        {
            $user_termine = mysqli_fetch_assoc($res);
            $row = 1;
            while ($row < mysqli_num_rows($res))
            {
                echo "<tr>";
                echo "td".$row['Termin_id'];
            }

        }


    }
}



