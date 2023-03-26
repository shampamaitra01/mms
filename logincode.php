<?php
include('security.php');

if(isset($_POST['login_btn']))
{
    $email_login = $_POST['userEamail']; 
    $password_login = md5($_POST['userPassword']); 

    $query = "SELECT * FROM user WHERE user_email='$email_login' AND password='$password_login' LIMIT 1";
    $statement = $connect->prepare($query);
    $statement->execute();
    $rowCount = $statement->rowCount();

   if($rowCount>0)
   {
        $_SESSION['username'] = $email_login;
        header('Location: user');
   } 
   else
   {
        $_SESSION['status'] = "Email / Password is Invalid";
        header('Location: login');
   }
    
}
?>