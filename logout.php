<?php
    session_start();
    unset($_SESSION['mail']);
    header("location: Login.php");
