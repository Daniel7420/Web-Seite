<?php
$dbServername = "localhost";
$dbUser = "dsnz23";
$dbPassword = "drvc2G3E5vobjurk";
$dbName = "dsnz23_2";

if(!$conn = mysqli_connect($dbServername, $dbUser, $dbPassword, $dbName)){
    die("failed to connect");
}
echo "Mit DB verbunden";
