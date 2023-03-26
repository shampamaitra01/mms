<?php
include(dirname(__FILE__).'/../config.php');

$getValue = mysqli_query($conn,"SELECT * FROM applied_form INNER JOIN previous_academic_records ON applied_form.student_id=previous_academic_records.applied_id WHERE student_id = '123013'");

              foreach ($getValue as $get){
                          
            	$swap_var1= array(

            		"{student_id}" => $get["student_id"],
            		"{student_name}" => $get["student_name"],
            		"{student_dept}" => $get["student_dept"],
            		"{student_mobile}" => $get["student_mobile"],
            		"{student_email}" => $get["student_email"],
            		"{student_batch}" => $get["batch"],
            		"{degre}" => $get["batch"],  

            	);
                                    
              }


    // allow for demo mode testing of emails
	define("DEMO", false); // setting to TRUE will stop the email from sending.

	// set the location of the template file to be loaded
	$template_file = "template.php";

	// set the email 'from' information
	$email_from = "GUB <info.gub@green.edu.bd>";

	// create a list of the variables to be swapped in the html template
	$swap_var2= array(
		"{SITE_ADDR}" => "https://www.green.edu.bd",
		"{EMAIL_LOGO}" => "https://green.edu.bd/wp-content/uploads/2017/08/Logo.png",
		"{EMAIL_TITLE}" => "Test Email!",
		"{CUSTOM_URL}" => "http://forms.green.edu.bd/dept-change/",
		"{CUSTOM_IMG}" => "",
		"{TO_NAME}" => " Sir",
		"{TO_EMAIL}" => "pro-vc@green.edu.bd"
	);
	$swap_var=array_merge($swap_var1,$swap_var2);
	

	// create the email headers to being the email
	$email_headers = "From: ".$email_from."\r\nReply-To: ".$email_from."\r\n";
	$email_headers .= "MIME-Version: 1.0\r\n";
	$email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // load the email to and subject from the $swap_var
	$email_to = $swap_var['{TO_EMAIL}'];
	$email_subject = $swap_var['{EMAIL_TITLE}']; // you can add time() to get unique subjects for testing: time();

	// load in the template file for processing (after we make sure it exists)
	if (file_exists($template_file))
		$email_message = file_get_contents($template_file);
	else
		die ("Unable to locate your template file");

	// search and replace for predefined variables, like SITE_ADDR, {NAME}, {lOGO}, {CUSTOM_URL} etc
	foreach (array_keys($swap_var) as $key){
		if (strlen($key) > 2 && trim($swap_var[$key]) != '')
			$email_message = str_replace($key, $swap_var[$key], $email_message);
	}
	
	// display the email template back to the user for final approval
	echo $email_message;

    // check if the email script is in demo mode, if it is then dont actually send an email
	if (DEMO)
		die("<hr /><center>This is a demo of the HTML email to be sent. No email was sent. </center>");

	// send the email out to the user	
	if ( mail($email_to, $email_subject, $email_message, $email_headers) )
		echo '<hr /><center>Success! Your email has been sent to '. $email_to .'</center>';
	else
		echo '<hr /><center> UNSUCCESSFUL... Your email was <b>NOT</b> sent. </center>';

?>