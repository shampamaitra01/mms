<?php
session_start();
include('database/dbconfig.php');
if($connect)
{
    // echo "Database Connected";
}
else
{
    header("Location: database/dbconfig.php");
}

if(!$_SESSION['username'])
{
    header('Location: login');
}
?>