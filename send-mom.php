<?php
//mom in pdf
include('database/dbconfig.php');
require_once('class/tcpdf/tcpdf.php');
require_once('class/class.phpmailer.php');
require_once('class/class.smtp.php');


class MYPDF extends TCPDF {

    //Page header
    public function Header($meeting_title) {
        // Logo
        $image_file = K_PATH_IMAGES.'gub.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, 'L', false, false, 0, false, false, false);
     

         

        $image_file = K_PATH_IMAGES.'mujib.png';
        $this->Image($image_file, 10, 10, 15, '', 'PNG', '', 'T', false, 300, 'R', false, false, 0, false, false, false);
        $this->SetFont('times', 'B', 15);
        //$this->Cell(0, 15,$meeting_title , 0, 1, 'C');
        $txt = <<<EOD
$meeting_title
EOD;
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        
        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('GUB IT');
$pdf->SetTitle('');
$pdf->SetSubject('');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

// set some text to print
$txt = <<<EOD

EOD;

// print a block of text using Write()
//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document


//============================================================+
// END OF FILE
//============================================================+

if(isset($_GET["code"]))
{
	$meeting_id=$_GET['code'];



	$query = "SELECT * FROM all_meeting_mms WHERE id = '".$meeting_id."'";

	$statement = $connect->prepare($query);
	$statement->execute();
	$getMettingInfo = $statement->fetchAll();
	if ($getMettingInfo) {
		foreach($getMettingInfo as $value)

		{	
			
			$meetTitle=$value["meeting_title"];
			$pdf->Header('Meeting Minutes of The proceedings of the 39 th (4 th of 2020) Meeting of the
Syndicate were reviewed and confirmed without any change
and amendment...'.$meetTitle);
			$output = '<div style="text-align: center;"><h3>Meeting Minutes of '.$value["meeting_title"].' </h3></div>'.
			'<p>Introduction: '.$value["meeting_description"].' </p>';

		}
		
	
	
	$output .= '
			<table border="1" cellpadding="6" cellspacing="2">
			<tr>
			<th style="width:25px;">SL.</th>
			<th style="width:100px"  align="center">Agenda Items</th>
			<th style="width:400px"  align="center">Discussions and Decisions</th>
			<th style="width:100px">Responsible Persons</th>
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
                            <td style="text-align: justify">'. $value1["decisions"].'</td>
                            <td> '.$value1["responsible_person"].'</td>
                            
                        </tr>';
                        
                        $sl++;

					}
				}

			
		}
	}


}
	
$output .= '</table>';
$output =  preg_replace('/\s\s+/', '', $output);
$pdf->SetFont('times', '', 12);
// output the HTML content
$pdf->writeHTML($output, true, 0, true, 0);

	
$pdf->lastPage();	
	
$pdf_file=$pdf->Output($meetTitle, 'S');


	

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

    

    $mail->Username = 'forms@green.edu.bd';

    $mail->Password = 'admin@gubit';

   

    $mail->From = 'forms@green.edu.bd';

    $mail->FromName = 'Rushad';

    $mail->AddAddress('rushad.it@green.edu.bd', '');

    $mail->WordWrap = 50;

    
    $mail->AddStringAttachment($pdf_file,$meetTitle.'.pdf');
    $mail->IsHTML(true);

    $mail->Subject = 'Attachment send';

    $mail->Body = 'Hello! Please see the attached file';
if($mail->Send())								//Send an Email. Return true on success or false on error
	{
		echo $message = '<label class="text-success">meeting minutes has been send successfully...</label>';
	}else{
		echo 'Failed to sent'. $mail->ErrorInfo;
	}


	
	exit(0);
}


?>