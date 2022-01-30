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
        $datum = $user_appointment['Datum'];
        $link = $user_appointment['link'];
        echo "<p>$name steht am $datum um $zeit an, beeil dich! </p><br><br>";
        echo "<a href = '$link'>Ab zum Meeting!</a>";
    }
    else
    {
    echo "Für heute bist du durch mit den Meetings";
    die;
    }

}
function getNextMeeting($conn, $user_data){
    if(isset($user_data['id'])){
        $id = $user_data['id'];
        $current_date = date('Y-m-d', time());
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

function build_calendar ($conn, $user_data)
{
    if (isset($user_data['id'])) {
        $id = $user_data['id'];
        $current = date('Y-m-d', time());

        #Probleme beim Finden des aktuellen Montags, da die Woche Sonntags beginnt
        if (date('w') == 0)
        {
            $monday = date('Y-m-d',time()+( 1 - date('w')-7)*24*3600); #gefunden: https://stackoverflow.com/questions/2958327/get-date-of-monday-in-current-week-in-php-4
            #echo "letzter Montag: ", $monday;
            $sunday = date('Y-m-d',time()+( 7 - date('w')-7)*24*3600); #gefunden: https://stackoverflow.com/questions/2958327/get-date-of-monday-in-current-week-in-php-4
            #echo "nächster Sonntag: ", $sunday;
        }
        else
        {
        $monday = date('Y-m-d',time()+( 1 - date('w'))*24*3600); #gefunden: https://stackoverflow.com/questions/2958327/get-date-of-monday-in-current-week-in-php-4
        #echo "letzter Montag: ", $monday;
        $sunday = date('Y-m-d',time()+( 7 - date('w'))*24*3600); #gefunden: https://stackoverflow.com/questions/2958327/get-date-of-monday-in-current-week-in-php-4
        #echo "nächster Sonntag: ", $sunday;
        }

        /*
         * Ansatz: Array so aufbauen, dass man zum Generieren des Kalenders (Zuerst Zeile, dann Spalte)
         * ein Array erstellt.
         * Multidimensionales Array [0] => Schulplanerzeiten,
         * Array[1] alle Daten zu einem Termin, der in der jeweiligen Uhrzeit stattfindet.
         */

        $sql = "select * from Termin where Nutzer_id = '$id' and Datum BETWEEN '$monday' AND '$sunday' order by `Termin`.`Zeitv`, `Termin`.`Datum`";
        $res = $conn->query($sql);

        $array_termine = array();
        $array_Zeit = ['08:00:00', '09:45:00', '11:30:00', '13:00:00', '14:00:00', '15:45:00', '17:30:00', '19:15:00', '21:00:00'];

        /*
         * Array_zeit (
         * [0] => 08:00:00
         * [1] => 09:30:00
         * [2] => 11:15:00
         * [3] => 13:00:00
         * )
         *
         */

        if (mysqli_num_rows($res) > 0) {
            while ($row3 = mysqli_fetch_assoc($res)) {

                $array_termine[] = $row3;
                #erstellt immer einen neuen eintrag in $array für jede zeile
            }
            #print_r($array_termine);
            #print_r($array_Zeit);
            #echo "Konstant:", $monday ;

        }

        $j = 0;
        while ($j < count($array_Zeit))
            #generiert alle Zeilen 0<9
        {
            echo "<tr>";
            #jte Zeile
            echo "<td>", $array_Zeit[$j], "</td>";
            #1 Spalte der jten Zeile
            $weekday = $monday;
            #erste Montag der Woche
            $a = 0;
            while ($a < 7)
                #generiert weitere 7 Spalten pro Zeile
            {
                echo "<td>";
                #Anfang nächste Spalte
                    $i = 0;
                    while ($i < count($array_termine)) {
                        #echo $array_termine[$i]['Zeitv'];
                        if ($array_termine[$i]['Zeitv'] >= $array_Zeit[$j] && $array_termine[$i]['Zeitv'] < $array_Zeit[$j + 1]) {
                            #Termin i Zeit >= jte Zeit & kleiner gleich jte +1 Zeit
                            if ($array_termine[$i]['Datum'] == $weekday) {
                                $nutzer = $user_data['id'];
                                $modul_id = $array_termine[$i]['Modul_id'];
                                $quer = "select * from Modul where Nutzer_id = '$nutzer' and id = $modul_id";
                                $resultat = $conn->query($quer);
                                $modul = mysqli_fetch_assoc($resultat);
                                echo $modul['name'], " von ", $array_termine[$i]['Zeitv'], " bis ", $array_termine[$i]['Zeitb'], "<br>";
                            }
                        }
                        $i = $i+1;
                    }
                $a = $a + 1;
                echo "</td>";
                #echo $weekday = date('Y-m-d',time()+( (1 + $a) - date('w'))*24*3600);
                $weekday = date("Y-m-d", strtotime("$weekday") + (3600 * 24));
            }
            $j = $j + 1;
            echo "</tr>";
        }

        }

}


function show_user_meetings($conn, $user_data, $user_modul) // unsterstützt anhand der Anleitung von Stackoverflow: https://stackoverflow.com/questions/33331430/php-list-users-from-sql-database-in-table
#https://www.youtube.com/watch?v=gnkI7hIC2RU
{
    if(isset($user_data['id']))
    {
        $id = $user_data['id'];
        $modul = $user_modul['id'];
        $sql = "select * from Modul where Nutzer_id = '$id'";
        $res = $conn->query($sql);

        $array = array();
        if (mysqli_num_rows($res) > 0)
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $array[] = $row;
                #erstellt immer einen neuen eintrag in $array für jede zeile
            }

            $i = 0;
            while ($i < count($array))
            {
                $modul_id = $array[$i]['id'];
                $modul_name = $array[$i]['name'];
                $link = $array[$i]['link'];
                $beschreibung = $array[$i]['beschreibung'];
                #echo $modul_id;
                $sql = "select * from Termin where Modul_id = '$modul_id' order by Termin.Datum, Termin.Zeitv DESC";
                $result = $conn->query($sql);
                #$alletermine = array();

                    #$user_termin_modul = mysqli_fetch_assoc($result);
                    #$user_termin_modulname = $user_termin_modul['name'];

                    echo "<input type='checkbox' id=$modul_id class='notseen'/>";
                    echo "<label for=$modul_id>$modul_name</label>";
                    echo '<div class="content notseen">';
                    echo "<div style: flex>";
                    echo "<div style='flex: 1'>Beschreibung: $beschreibung </div>";
                    while ($row2 = mysqli_fetch_assoc($result))
                    {
                        #$alletermine[] = $row2;

                        echo "<div>";
                        echo '<p> Am ', $row2['Datum'], ' von ', $row2['Zeitv'], ' bis ', $row2['Zeitb'], '</p>';
                        echo "</div>";

                    }

                    echo "<a href='$link'>Zum Meeting! </a>";
                    echo "</div>";
                    echo "</div>";

                $i = $i + 1;
            }
        }
    }
}

function get_modules_as_array($user_data, $conn)
{
    $id = $user_data['id'];
    $query = "select name from Modul where Nutzer_id = '$id'";
    $res = $conn->query($query);
    $array = array();

    while ($row = mysqli_fetch_assoc($res))
    {
        $array[] = $row;
    }
    return $array;
}
function create_module_dropdown($array)
{
    $i = 0;
    if (!empty($array)) {
        while ($i < count($array)) {
            $value = $array[$i]['name'];
            echo "<option value='$value'>$value</option>";
            $i = $i + 1;
        }
    }
    else
    {
        echo "<option value='Noch kein Modul angelegt'>Kein Modul vorhanden</option>";
    }
}

function create_note_dropdown($conn, $user_data)
{
    $Nutzer_id = $user_data['id'];

    $sql = "select * from Notiz where Nutzer_id = $Nutzer_id";
    $rs = $conn->query($sql);
    $user_notes = array();
    while ($row = mysqli_fetch_assoc($rs))
    {
        $user_notes[] = $row;
    }
    $i = 0;
    if (!empty($user_notes)) {
        while ($i < count($user_notes)) {
            $value = $user_notes[$i]['name'];
            $value2 = $user_notes[$i]['id'];
            echo "<option value='$value2'>$value</option>";
            $i = $i + 1;
        }
    }
    else
    {
        echo "<option value='Noch kein Modul angelegt'>Kein Modul vorhanden</option>";
    }
}

function create_appointment_dropdown($conn, $user_data)
{
    $Nutzer_id = $user_data['id'];

    $sql = "select * from Termin where Nutzer_id = $Nutzer_id";
    $resultat = $conn->query($sql);
    $user_notes = array();
    while ($row = mysqli_fetch_assoc($resultat))
    {
        $user_appointments[] = $row;
    }
    $i = 0;
    if (!empty($user_appointments)) {
        while ($i < count($user_appointments)) {
            $value = $user_appointments[$i]['Beschreibung'];
            $value2 = $user_appointments[$i]['Termin_id'];
            echo "<option value='$value2'>$value</option>";
            $i = $i + 1;
        }
    }
    else
    {
        echo "<option value='Noch kein Modul angelegt'>Kein Modul vorhanden</option>";
    }
}
function show_user_notes ($conn, $user_data)
{
    if(isset($user_data['id']))
    {
        $id = $user_data['id'];
        $sql = "select * from Notiz where Nutzer_id = '$id'";
        $res = $conn->query($sql);

        $array = array();
        if (mysqli_num_rows($res) > 0)
        {
            while ($row = mysqli_fetch_assoc($res))
            {
                $array[] = $row;
                #erstellt immer einen neuen eintrag in $array für jede zeile

            }
            $i = 0;
            while ($i < count($array))
            {
                $modulname = $array[$i]['modul_id'];
                $notiz_id = $array[$i]['id'];
                $a = $array[$i]['name'];
                echo "<input type='checkbox' id='$notiz_id' class='notseen'/>";
                echo "<label for='$notiz_id'>$a</label>";
                echo '<div class="content notseen">';
                echo '<p>', $modulname, '</p>';
                echo "<p>", $array[$i]['text'], "</p>";
                echo "</div>";

                $i = $i + 1;
            }
        }
    }
}




