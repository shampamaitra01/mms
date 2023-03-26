<?php
//mom in pdf
include('../database/dbconfig.php');
require_once('../class/pdf.php');
require_once('../class/class.phpmailer.php');
require_once('../class/class.smtp.php');

if(isset($_GET["code"]))
{
	$meeting_id=$_GET['code'];

	$output = '<div style="margin-top:50px;">

	<img style="float: left; position: fixed; width:10%; height:10% ;"  src="img/l-2.png">
	<img style="float: right; position: fixed; width:10% height:10%"  src="img/mujib.png">
	<h2 align="center">Green University of Bangladesh</h2>

	</div>';

	$query = "SELECT * FROM all_meeting_mms WHERE id = '".$meeting_id."'";

	$statement = $connect->prepare($query);
	$statement->execute();
	$getMettingInfo = $statement->fetchAll();
	if ($getMettingInfo) {
		foreach($getMettingInfo as $value)
		{
			$output .= '<div align="center"><h3>Meeting Minutes of '.$value["meeting_title"].' </h3></div>';
			$output .= '<p>Introduction: '.$value["meeting_description"].' </p>';

		}
	}
	
	$output .= '
			<table width="100%" border="1" cellpadding="5" cellspacing="0">
			<tr>
			<th>SL.</th>
			<th>Agenda Items</th>
			<th>Discussions and Decisions</th>
			<th>Responsible Persons</th>
			</tr>';

	$query = "SELECT * FROM agenda_mms WHERE meeting_id = '".$meeting_id."'";

	$statement = $connect->prepare($query);
	$statement->execute();
	$getGendaInfo = $statement->fetchAll();
	$sl =01;
	if ($getGendaInfo) {
		foreach($getGendaInfo as $value)
		{
			$agenda_id=$value['id'];
			$query1 = "SELECT * FROM decision_mms WHERE agenda_id = '".$agenda_id."'";
			$statement1 = $connect->prepare($query1);
			$statement1->execute();
			$getDecionsInfo = $statement1->fetchAll();
			if ($getDecionsInfo) {
				foreach($getDecionsInfo as $value1)
					{
						$output .= '<tr>
                            <td>'.$sl.'</td>
                            <td>'.$value["agenda_title"].'</td>
                            <td><b> Discussion:</b> '.$value1["discussion"].'<br><b>Decisions:</b> '.$value1["decisions"].'</td>
                            <td> '.$value["meeting_id"].'</td>
                            
                        </tr>';
                        $sl++;

					}
				}

			
		}
	}



	
	$output .= '</table>';

	$pdf = new Pdf();

	$pdf->set_paper('A4','portrait');

	$file_name = 'mom.pdf';

	$pdf->loadHtml($output);

	$pdf->render();

	$pdf->stream($file_name, array("Attachment" => false));

	$file = $pdf->output();
	file_put_contents($file_name, $file);
	

    $mail = new PHPMailer;
    
    $mail->isSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;                                   // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                              // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = '587';

    

    $mail->Username = 'rushadbinsayeed@gmail.com';

    $mail->Password = 'rushad123';

   

    $mail->From = 'rushadbinsayeed@gmail.com';

    $mail->FromName = 'Rushad';

    $mail->AddAddress('rushad.it@green.edu.bd', '');

    $mail->WordWrap = 50;

    $mail->IsHTML(true);
    $mail->AddAttachment($file_name);

    $mail->Subject = 'Attachment send';

    $mail->Body = 'Hello';

	// if($mail->Send())//Send an Email. Return true on success or false on error
	// {
	// 	$message = '<label class="text-success">Customer Details has been send successfully...</label>';
	// }


	unlink($file_name);
	exit(0);
}


?>