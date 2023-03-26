<?php
session_start();
include('includes/header.php');
include('database/dbconfig.php'); 
?>

<?php
function redirect($page)
  {
    header('location:'.$page);
    exit;
  }

if(isset($_GET['verficationId'], $_GET['verified']))
{


 $verficationId=$_GET['verficationId'];

}
if(isset($_POST['setPassBtn']))
{
      $password=$_POST['password'];
      $password_encrypt = md5($password);
        $data = array(
                 ':user_password' => $password_encrypt
                 
                 
                );
        $query = " UPDATE user SET password = :user_password WHERE verfication_code ='".$verficationId."' ";

        $statement = $connect->prepare($query);
        if($statement->execute($data))
          {

            redirect('login.php?passwordset=success');
          }
}
?>


<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-6 col-lg-6 col-md-6">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Set your password!</h1>
                <?php

                    if(isset($_SESSION['status']) && $_SESSION['status'] !='') 
                    {
                        echo '<div class="alert alert-success"> '.$_SESSION['status'].' </div>';
                        unset($_SESSION['status']);
                    }
                ?>
              </div>

                <form class="user" action="" method="POST">

                    <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                    </div>
                    <div class="form-group">
                    <input type="password" name="comfirmPassword" class="form-control form-control-user" placeholder="Comfirm Password">
                    </div>
            
                    <button type="submit" name="setPassBtn" class="btn btn-primary btn-user btn-block"> Set Password </button>
                    <hr>
                </form>


            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>


<?php
include('includes/scripts.php'); 
?>