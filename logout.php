<?php
session_start(); //Start the current session

 //Destroy it! So we are logged out now
if (isset($_POST["logout_btn"])) {
	session_destroy();
	unset($_SESSION['username']);
	header("location:login?msg=Successfully Logged out");
}
?>