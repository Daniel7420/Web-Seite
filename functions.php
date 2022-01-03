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

function build_calendar ($conn){

    $id = $_SESSION['id'];                                                                              #id des aktuellen Nutzers
    $sql = "select * from Termin where Nutzer_id = '$id' order by Datum, Zeitv";                        #giebt alle Termine des Nutzers wieder
    $result = $conn-->query($sql);
    $current_date = date('Y-m-d', time());
    $array = array(
        '0' => $array("U1", "U2", "U3", "U4", "U5", "U6", "U7", "U8", "U9"),
        '1' => array ("-", "--", "---", "----", "-----", "------", "-------", "--------", "---------", "----------"),
        '2' => array ("_", "--", "---", "----", "-----", "------", "-------", "--------", "---------", "----------"),
        '3' => array (".", "--", "---", "----", "-----", "------", "-------", "--------", "---------", "----------")
    );

    while ($i = 0 < 7)
    {
        while($j = 0 < 9) {
#schleife muss erstmal über die Zeilen laufen und danach über die spalten!
            echo "<td>", "</td>";
            echo "<tr>";
            echo "<td>", $array[$i][$j], "</td>";
            $j = $j +1;
        }
        $j = 0;
        $i = $i + 1;
    }

    #Montag festlegen
    if (mysqli_num_rows($result) > 0)                                                                   #gibt es Termine für die angezeigte Woche
    {
        $user_termine = mysqli_fetch_assoc($result);                                                    #nur diese Termine sollen im Array gespeichert werden
               #while()/foreach(start:Montag, Ende Sonntag, Tag++                                       #gibt es am Montag einen termin
       #$z1 = '-';
        #$z1 = $user_termine['beschreibung']

    }

}

function show_user_meetings($conn, $user_data, $user_modul) // unsterstützt anhand der Anleitung von Stackoverflow: https://stackoverflow.com/questions/33331430/php-list-users-from-sql-database-in-table
#https://www.youtube.com/watch?v=gnkI7hIC2RU
{
    if(isset($user_data['id']))
    {
        $id = $user_data['id'];
        $modul = $user_modul['id'];
        $sql = "select * from Termin where Nutzer_id = '$id'";
        $res = $conn->query($sql);

        $array = array();
        if (mysqli_num_rows($res) > 0)
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $array[] = $row;
                #erstellt immer einen neuen eintrag in $array für jede zeile

            }
            $num = count($array);
            #print_r($array);
            #echo $num;
            $i = 0;


            while ($i < count($array))
            {
                $modul_id = $array[$i]['Modul_id'];
                echo $modul_id;
                $sql = "select * from Modul where id = '$modul_id'";
                $result = $conn->query($sql);
                if (mysqli_num_rows($result) > 0)
                {
                    $user_termin_modul = mysqli_fetch_assoc($res);
                    $user_termin_modulname = $user_termin_modul['name'];
                    echo $user_termin_modulname;
                    echo "<p> <strong>Meeting", $i+1, ": ", $user_termin_modulname, "</strong></p>";
                    echo "<p>", $array[$i]['Beschreibung'], "</p>";
                    echo "<p>", $array[$i]['Datum'], " Zeit: ",$array[$i]['Zeitv'], "</p>";
                    echo "<p>", $array[$i]['link'], "</p>";
                    $i = $i + 1;
                }

            }
        }



    }
}



