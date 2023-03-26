<?php
session_start();
//verify_email.php

include('database/dbconfig.php');

function redirect($page)
	{
		header('location:'.$page.'');
		exit;
	}

if(isset($_GET['type'], $_GET['code']))
{	
	
	// if($_GET['type'] == 'master')
	// {
	// 	$exam->data = array(
	// 		':email_verified'		=>	'yes'
	// 	);

	// 	$exam->query = "
	// 	UPDATE admin_table 
	// 	SET email_verified = :email_verified 
	// 	WHERE admin_verfication_code = '".$_GET['code']."'
	// 	";

	// 	$exam->execute_query();

	// 	$exam->redirect('master/login.php?verified=success');
	// }

	if($_GET['type'] == 'user')
	{
		$verificationId = $_GET['code']; 
    	 

    	$query = "SELECT * FROM user WHERE verfication_code='$verificationId' AND is_verified='yes' LIMIT 1";
    	$statement = $connect->prepare($query);
    	$statement->execute();
    	$rowCount = $statement->rowCount();

    	if($rowCount>0)
	   	{
	        $_SESSION['status'] = "Email verfication already completed";
	        header('Location: login');
	   	} 
	   	else
	   	{
	   	 $data = array(
			':is_verified'	=>	'yes'
		);

		$query = "
		UPDATE user 
		SET is_verified = :is_verified 
		WHERE verfication_code = '".$_GET['code']."'
		";

		$statement = $connect->prepare($query);
		if($statement->execute($data)){

			$_SESSION['status'] = "Please set your password";

			redirect('setpassword?verficationId='.$_GET['code'].'&verified=success');
			}

   		}

		
	}
}


?>