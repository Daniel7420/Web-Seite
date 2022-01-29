<?php
if (isset($_POST['text'])) {
    include ("connection.php");
    $sql = "INSERT into Termin (Beschreibung) VALUES (?)"; //enter your MySQL query here. Where you need the data from the text editor, replace with a "?"
    $stmt = $conn->prepare($sql); // prepare statement
    $stmt->bind_param("s", $_POST['text']); //assign variable to the "?" placeholder
    $stmt->execute(); //run the MySQL query
}