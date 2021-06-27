<?php

session_start();

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
}

header("Location: e-Exam Portal.php");
die;
?>
