<?php
include('database/dbconfig.php');
require_once('class/class.phpmailer.php');
require_once('class/class.smtp.php');


function send_email($to, $subject, $message)
  {

    $mail = new PHPMailer;
    
    $mail->isSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;       // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;       // Enable SMTP authentication
                              
    $mail->SMTPSecure = 'tls';
    $mail->Port = '587';

    

    $mail->Username = 'rushadbinsayeed@gmail.com';

    $mail->Password = 'rushad123';

   

    $mail->From = 'rushadbinsayeed@gmail.com';

    $mail->FromName = 'GUB Meeting Management System';

    $mail->AddAddress($to, '');

    $mail->IsHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $message;

    
    if(!$mail->send()) {
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {
          echo '';
      }    
  }

$output2 ='';
if (isset($_POST["actionForMemlist"])) {
    if($_POST["actionForMemlist"] == 'fetch')
   {
    if($_POST["isSetMemList"]==""){

      $query = "
      SELECT * FROM member_list_category_mms ORDER BY id ASC
      ";
      $statement = $connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      {
      $output2 .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
      
      }
     }else if($_POST["isSetMemList"]=="isSetMemListCategory"){

      $query = "SELECT  *
      FROM    allmemlist_mms
      WHERE   id  IN (SELECT membership_id FROM memberlist_mms WHERE mem_list_category_id={$_POST['memListcategory_id']})";
      $statement = $connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      {
      $output2 .= '<option value="'.$row["id"].'" selected>'.$row["member_affiliation"].'</option>';
      
      }

     }

      
      echo $output2;
   }

}


$output = ''; 



if(isset($_POST["action"]))
{
  //Data View in Data DTable
	if($_POST["action"] == 'fetch')
 {
  // $query = "
  // SELECT * FROM all_metting_mms 
  // INNER JOIN meeting_type_mms 
  // ON meeting_type_mms.id = all_metting_mms.meeting_type_id ";

  // $query = "SELECT * FROM all_meeting_mms WHERE meeting_date > CURDATE()";
  
  $query = "SELECT * FROM all_meeting_mms WHERE";

  if(isset($_POST["search"]["value"]))
  {
   // $query .= 'WHERE all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%" ';
  	   $query .= ' meeting_title LIKE "%'.$_POST["search"]["value"].'%"';
  }
  if(isset($_POST["order"]))
  {
   $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
  }
  else
  {
   $query .= 'ORDER BY id DESC ';
  }
  if($_POST["length"] != -1)
  {
   $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
  }

  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $data = array();
  $filtered_rows = $statement->rowCount();
  foreach($result as $row)
  {
   $sub_array = array();
   $agenda_button = '';
   // $sub_array[] = '<img src="teacher_image/'.$row["teacher_image"].'" class="img-thumbnail" width="75" />';
   $sub_array[] = $row["id"];
   $sub_array[] = $row["meeting_title"];
   $sub_array[] = $row["meeting_description"];
   // $sub_array[] = $row["grade_name"];
   $sub_array[] = '<a href="agenda.php?code='.$row['id'].'&title='.$row['meeting_title'].'" class="btn btn-outline-success btn-sm" target="_blank"><i class="fas fa-eye"></i> View Agenda</a>';
   $viewMeetingButton= '<button type="button" name="view_meeting" class="badge badge-info view_meeting" id="'.$row["id"].'"><i class="fas fa-eye"></i> View</button>';
   $editMeetingButton = '<button type="button" name="edit_meeting" class="badge badge-primary edit_meeting" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit</button>';
   $deleteMeetingButton= '<button type="button" name="delete_meeting" class="badge badge-danger  delete_meeting" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';
   $sub_array[]=$viewMeetingButton.' '.$editMeetingButton.' '.$deleteMeetingButton;
   $sub_array[]= '<a href="mom.php?code='.$row['id'].'" class="btn btn-outline-info btn-sm" target="_blank"><i class="fas fa-eye"></i> View</a>';
   $sub_array[]= '<a href="send-mom.php?code='.$row['id'].'" class="btn btn-outline-info btn-sm" target="_blank"><i class="fas fa-envelope"></i> Send</a>';
   // $sub_array[] = '<button type="button" name="delete_teacher" class="btn btn-danger btn-sm delete_teacher" id="'.$row["id"].'">Delete</button>';

   $data[] = $sub_array;
  }

  $output = array(
   "draw"    => intval($_POST["draw"]),
   "recordsTotal"  =>  $filtered_rows,
   "recordsFiltered" => get_agenda_records($connect, 'all_meeting_mms'),
   "data"    => $data
  );
  echo json_encode($output);
 }
 //End of Data View in Data Table

 if($_POST["action"] == 'Add' || $_POST["action"] == "Edit")
 {


    $meeting_title = $_POST["meeting_title"];
    $meeting_type_id = $_POST["meeting_type_id"];
    $memberListCategory=$_POST["memberListCategory"];
    $hidden_meeting_member_list=$_POST["hidden_meeting_member_list"];
    $meeting_description= $_POST["meeting_description"];
    $meeting_mode=$_POST["meeting_mode"];
    
    $meeting_date=$_POST["meeting_date"];
    $meeting_stime=$_POST["meeting_stime"];
    $meeting_etime= $_POST["meeting_etime"];
    
    $create_date='x';

    if ($meeting_mode=='online') {
      $meeting_venue=$_POST["meeting_link"];
    }else{
      $meeting_venue=$_POST["meeting_venue"];
    }


  
   if($_POST["action"] == "Add")

   {
    try{
    $data = array(
     ':meeting_title'   => $meeting_title,
     ':meeting_type_id'   => $meeting_type_id,
     ':meeting_description'   => $meeting_description,
     ':meeting_mode'     => $meeting_mode,
     ':meeting_venue'   => $meeting_venue,
     ':meeting_date'   => $meeting_date,
     ':meeting_stime' => $meeting_stime,
     ':meeting_etime'    => $meeting_etime
     
     
    );
    $query = "INSERT INTO all_meeting_mms 
    (meeting_title, meeting_type_id, meeting_description,meeting_mode, meeting_venue, meeting_date, meeting_stime, meeting_etime) VALUES (:meeting_title,:meeting_type_id,:meeting_description,:meeting_mode,:meeting_venue,:meeting_date,:meeting_stime,:meeting_etime)";

    $statement = $connect->prepare($query);

    $statementexe=$statement->execute($data);
    $lastId = $connect->lastInsertId();

    if($statementexe)
    // {

    //  $queryForgetingEmail="SELECT * FROM memberlist_mms WHERE meid='".$memberListCategory."'";

    //   $statementForgetingEmail = $connect->prepare($queryForgetingEmail);
    //   $statementForgetingEmail->execute();
    //   $gelAllEmail = $statementForgetingEmail->fetchAll();
    //   $rowCount = $statementForgetingEmail->rowCount(); 

    //   if ($rowCount>0) {
        
      

    //   foreach ($gelAllEmail as $participantEmail)
    //   {
                           
    //           $to=$participantEmail["member_email"];             

    //           $subject = $meeting_title;              

    //           $message =nl2br('

    //             "This is a system generated email, don\'t send back any reply to this email, should you have any query please contact "

                

    //             Dear Sir/Madam,
                
    //             ------------------------

                

    //             ------------------------

                



    //             Regards,

    //             Green University of Bangladesh (GUB).'); 


    //             send_email($to,$subject,$message);    
                          
    //   }


    //   $output = array(
    //    'success'  => 'Meeting has been created successfully',
    //   );

    // }else{
    //   $output = array(
    //    'error'  => 'No email Address found',
    //   );
    // }



    //  }
          {

            foreach ($_POST["meeting_agenda"] as $key => $value) {
            $query = "INSERT INTO agenda_mms
            (agenda_title,meeting_id) VALUES (:agenda_title,:meeting_id)";
            $statement = $connect->prepare($query);
            $statementexe=$statement->execute([
            ':agenda_title'   => $value,
            ':meeting_id'     => $lastId
            ]);
            $lastIdForAgenda = $connect->lastInsertId();

            $data2 = array(
           ':agenda_id'     => $lastIdForAgenda
            );
            $query2 = "INSERT INTO decision_mms (agenda_id) VALUES (:agenda_id)";
            $statement2 = $connect->prepare($query2);
            $statementexe2=$statement2->execute($data2); 
            
          }



      

      if ($hidden_meeting_member_list!='') {

        $gelAllEmail=explode(",",$hidden_meeting_member_list);
      

      foreach ($gelAllEmail as $participantEmail)
      { 
                           
      $queryForgetingEmail="SELECT * FROM allmemlist_mms WHERE id='".$participantEmail."'";

      $statementForgetingEmail = $connect->prepare($queryForgetingEmail);
      $statementForgetingEmail->execute();
      $gelAllEmail1 = $statementForgetingEmail->fetchAll();
      $rowCount = $statementForgetingEmail->rowCount(); 

      if ($rowCount>0) {
        
      

      foreach ($gelAllEmail1 as $participantEmail1)
      {
                           
              $to=$participantEmail1["member_email"];             

              $subject = $meeting_title;              

              $message =nl2br('

                "This is a system generated email, don\'t send back any reply to this email, should you have any query please contact "

                

                Dear Sir/Madam,
                
                ------------------------

                

                ------------------------

                



                Regards,

                Green University of Bangladesh (GUB).'); 


              //send_email($to,$subject,$message);    
                          
      }


      $output = array(
       'success'  => 'Meeting has been created successfully',
      );

    }else{
      $output = array(
       'error'  => 'No email Address',
      );
    }

                
   }

    }else if ($hidden_meeting_member_list==''){
      
      $queryForgetingEmail="SELECT  * FROM    allmemlist_mms WHERE   id  IN (SELECT membership_id FROM memberlist_mms WHERE mem_list_category_id={$_POST['memberListCategory']})";

      $statementForgetingEmail = $connect->prepare($queryForgetingEmail);
      $statementForgetingEmail->execute();
      $gelAllEmail = $statementForgetingEmail->fetchAll();
      $rowCount = $statementForgetingEmail->rowCount(); 

      if ($rowCount>0) {
        
      

      foreach ($gelAllEmail as $participantEmail)
      {
                           
              $to=$participantEmail["member_email"];             

              $subject = $meeting_title;              

              $message =nl2br('

                "This is a system generated email, don\'t send back any reply to this email, should you have any query please contact "

                

                Dear Sir/Madam,
                
                ------------------------

                

                ------------------------

                



                Regards,

                Green University of Bangladesh (GUB).'); 


                //send_email($to,$subject,$message);    
                          
      }


      $output = array(
       'success'  => 'Meeting has been created successfully',
      );

    }else{
      $output = array(
       'error'  => 'No email Address found',
      );
    }

    }else{
      $output = array(
       'error'  => 'No email Address found Member list Empty',
      );
    }



     }
     else
     {
      $output = array(
       'error'     => true,
      );
     }
    


  }catch(PDOException $e){
    $error= $e->getMessage();
          $output = array(
       'error'     => $error
      );
  }
}



   if($_POST["action"] == "Edit")
   {
    $data = array(
     ':meeting_title'   => $meeting_title,
     ':meeting_type_id'   => $meeting_type_id,
     ':meeting_description'   => $meeting_description,
     ':meeting_venue'   => $meeting_venue,
     ':meeting_date'   => $meeting_date,
     ':meeting_stime' => $meeting_stime,
     ':meeting_etime'    => $meeting_etime,
     ':meeting_id'    => $_POST["meeting_id"]
    );
    $query = "
    UPDATE all_meeting_mms 
    SET meeting_title=:meeting_title,
    meeting_type_id=:meeting_type_id,
    meeting_description=:meeting_description,
    meeting_venue=:meeting_venue,
    meeting_date=:meeting_date,
    meeting_stime=:meeting_stime,
    meeting_etime=:meeting_etime
    WHERE id = :meeting_id
    ";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
     $output = array(
      'success'  => 'Meeting Edited Successfully',
     );
    }
   }
  
  echo json_encode($output);
}



//Fetch meeting for Edit in Modal
      if($_POST["action"] == "fetchForEditMeeting")
       {
        $query = "SELECT * FROM all_meeting_mms WHERE id = '".$_POST["meeting_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {

          $output["meeting_title"] = $row["meeting_title"];
          $output["meeting_type_id"] = $row["meeting_type_id"];
          $output["meeting_description"]= $row["meeting_description"];
          $output["meeting_venue"]=$row["meeting_venue"];
          $output["meeting_date"]=$row["meeting_date"];
          $output["meeting_stime"]=$row["meeting_stime"];
          $output["meeting_etime"]= $row["meeting_etime"];

          

          $output['meeting_id'] = $row['id'];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Meeting

       //Delete Meeting
       if($_POST["action"] == "deleteMeeting")
       {
        $query = "DELETE FROM all_meeting_mms WHERE id = '".$_POST["meeting_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
          
          $getAgendaId = "SELECT * FROM agenda_mms WHERE meeting_id = '".$_POST["meeting_id"]."'";
          $statementgetAgendaId = $connect->prepare($getAgendaId);

          if($statementgetAgendaId->execute()){

            $resultgetAgendaId = $statementgetAgendaId->fetchAll();
            foreach($resultgetAgendaId as $row)
              {
                $agendaId=$row["id"];
              
              }


          }

          $query2 = "DELETE FROM agenda_mms WHERE meeting_id = '".$_POST["meeting_id"]."'";
          $statement2 = $connect->prepare($query2);

          if($statement2->execute()){

            $query3 = "DELETE FROM decision_mms WHERE agenda_id = '".$agendaId."'";
            $statement3 = $connect->prepare($query3);

            if($statement3->execute()){

              echo '';
            }else{
            echo 'Something went wrong';
          }
            
          }else{
            echo 'Something went wrong';
          }
         echo 'Meeting Deleted Successfully';
        }else{
            echo 'Something went wrong';
        }

       } //Delete Meeting

if($_POST["action"] == 'single_fetch')
 {
  $query = "
  SELECT * FROM all_meeting_mms WHERE
  id = '".$_POST["meeting_id"]."'";
  $statement = $connect->prepare($query);
  if($statement->execute())
  {
   $result = $statement->fetchAll();
   $output = '
   <div class="row">
   ';
   foreach($result as $row)
   {
    $output .= '
    <div class="col-md-9">
     <table class="table">
      <tr>
       <th>Meeting Title</th>
       <td>'.$row["meeting_title"].'</td>
      </tr>
      <tr>
       <th>Description</th>
       <td>'.$row["meeting_description"].'</td>
      </tr>
      <tr>
       <th>Vanue</th>
       <td>'.$row["meeting_venue"].'</td>
      </tr>
      <tr>
       <th>Date</th>
       <td>'.$row["meeting_date"].'</td>
      </tr>
      <tr>
       <th>Start at</th>
       <td>'.$row["meeting_stime"].'</td>
      </tr>

     </table>
    </div>
    ';
   }
   $output .= '</div>';
   echo $output;
  }
 }

 



} //The first if closed

?>