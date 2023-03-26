<?php
include('database/dbconfig.php');
require_once('class/class.phpmailer.php');
require_once('class/class.smtp.php');

$output = ''; 
function send_email($participant_email, $subject, $emailMessage)
  {

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

    $mail->AddAddress($participant_email, '');

    $mail->IsHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $emailMessage;
    $mail->send();

    
    // if(!$mail->send()) {
    //       echo 'Message could not be sent.';
    //       echo 'Mailer Error: ' . $mail->ErrorInfo;
    //   } else {
    //       echo 'Message has been sent';
    //   }    
  }


if(isset($_POST["actionAddMtype"]))
{
  //Data View in Data DTable
	if($_POST["actionAddMtype"] == 'fetch')
 {
  // $query = "
  // SELECT * FROM all_metting_mms 
  // INNER JOIN meeting_type_mms 
  // ON meeting_type_mms.id = all_metting_mms.meeting_type_id ";
  $query = "
  SELECT * FROM meeting_type_mms ";
  if(isset($_POST["search"]["value"]))
  {
   // $query .= 'WHERE all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%" ';
  	   $query .= 'WHERE name LIKE "%'.$_POST["search"]["value"].'%"';
  }
  if(isset($_POST["order"]))
  {
   $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
  }
  else
  {
   $query .= 'ORDER BY id ASC ';
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
   $sub_array[] = $row["name"];
   
   // $sub_array[] = $row["grade_name"];
   
   $editMTypeButton = '<button type="button" name="editMtype" class="btn btn-primary btn-sm editMtype" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit</button>';
   $deleteMTypeButton= '<button type="button" name="deleteMtype" class="btn btn-danger btn-sm deleteMtype" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';
   $sub_array[]=$editMTypeButton.' '.$deleteMTypeButton;
   // $sub_array[] = '<button type="button" name="delete_teacher" class="btn btn-danger btn-sm delete_teacher" id="'.$row["id"].'">Delete</button>';
   $data[] = $sub_array;
  }

  $output = array(
   "draw"    => intval($_POST["draw"]),
   "recordsTotal"  =>  $filtered_rows,
   "recordsFiltered" => get_agenda_records($connect, 'meeting_type_mms'),
   "data"    => $data
  );
  echo json_encode($output);
 }
 //End of Data View in Data Table

 if($_POST["actionAddMtype"] == 'Add' || $_POST["actionAddMtype"] == "Edit")
 {


    $meeting_type = $_POST["meeting_type"];
    
    
  


  
   if($_POST["actionAddMtype"] == "Add")

   {
    try{
    $data = array(
     ':meeting_type'   => $meeting_type
     
     
    );
    $query = "INSERT INTO meeting_type_mms 
    (name) VALUES (:meeting_type)";

    $statement = $connect->prepare($query);

    $statementexe=$statement->execute($data);

    if($statementexe)
    {

      $output = array(
       'success'  => 'Meeting type has been added successfully',
      );
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



  if($_POST["actionAddMtype"] == "Edit")
   {

    $data = array(
     ':meeting_type'   => $meeting_type,
     ':mtype_id'    => $_POST["mtype_id"]
    );
    $query = "
    UPDATE meeting_type_mms 
    SET name=:meeting_type
    WHERE id = :mtype_id
    ";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
     $output = array(
      'success'  => 'Meeting type updated Successfully',
     );
    }
   }
  
  echo json_encode($output);
}



//Fetch meeting type for Edit in Modal
      if($_POST["actionAddMtype"] == "fetchForEditMtype")
       {
        $query = "SELECT * FROM meeting_type_mms WHERE id = '".$_POST["mtype_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {

          
          $output["meeting_type"] = $row["name"];
          

          

          $output['mtype_id'] = $row['id'];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Meeting Type

       //Delete Meeting Type
       if($_POST["actionAddMtype"] == "deleteMtype")
       {
        $query = "DELETE FROM meeting_type_mms WHERE id = '".$_POST["mtype_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
          echo 'Meeting type Deleted Successfully';

          
         
        }else{
            echo 'Something went wrong';
        }

       } //Delete Meeting Type



} //The first if closed


if(isset($_POST["actionForVenue"]))
{
  //Data View in Data DTable
  if($_POST["actionForVenue"] == 'fetch')
 {

  $query = "
  SELECT * FROM venues_mms ";
  if(isset($_POST["search"]["value"]))
  {
   // $query .= 'WHERE all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%" ';
       $query .= 'WHERE venue_name LIKE "%'.$_POST["search"]["value"].'%"';
  }
  if(isset($_POST["order"]))
  {
   $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
  }
  else
  {
   $query .= 'ORDER BY id ASC ';
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
   $sub_array[] = $row["venue_name"];
   

   
   $editVenueButton = '<button type="button" name="editVenue" class="btn btn-primary btn-sm editVenue" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit</button>';
   $deleteVenueButton= '<button type="button" name="deleteVenue" class="btn btn-danger btn-sm deleteVenue" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';
   $sub_array[]=$editVenueButton.' '.$deleteVenueButton;
   
   $data[] = $sub_array;
  }

  $output = array(
   "draw"    => intval($_POST["draw"]),
   "recordsTotal"  =>  $filtered_rows,
   "recordsFiltered" => get_agenda_records($connect, 'venues_mms'),
   "data"    => $data
  );
  echo json_encode($output);
 }
 //End of Data View in Data Table

         if($_POST["actionForVenue"] == 'Add' || $_POST["actionForVenue"] == "Edit")
         {


            $venue_name = $_POST["venue_name"];
            
           
               if($_POST["actionForVenue"] == "Add")

               {
                try{
                $data = array(
                 ':venue_name'   => $venue_name
                 
                 
                );
                $query = "INSERT INTO venues_mms 
                (venue_name) VALUES (:venue_name)";

                $statement = $connect->prepare($query);

                $statementexe=$statement->execute($data);

                if($statementexe)
                {

                  $output = array(
                   'success'  => 'New venue has been added successfully',
                  );
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



             if($_POST["actionForVenue"] == "Edit")
             {

              $data = array(
               ':venue_name'   => $venue_name,
               ':venue_id'    => $_POST["venue_id"]
              );
              $query = "
              UPDATE venues_mms 
              SET venue_name=:venue_name
              WHERE id = :venue_id
              ";
              $statement = $connect->prepare($query);
              if($statement->execute($data))
              {
               $output = array(
                'success'  => 'Venue updated Successfully',
               );
              }
             }
            
            echo json_encode($output);
          }



      //Fetch meeting type for Edit in Modal
      if($_POST["actionForVenue"] == "fetchForEditVenue")
       {
        $query = "SELECT * FROM venues_mms WHERE id = '".$_POST["venue_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {

          
          $output["venue_name"] = $row["venue_name"];
          

          

          $output['venue_id'] = $row['id'];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Venue

       //Delete Venue
       if($_POST["actionForVenue"] == "deleteVenue")
       {
        $query = "DELETE FROM venues_mms WHERE id = '".$_POST["venue_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
          echo 'Venue Deleted Successfully';

          
         
        }else{
            echo 'Something went wrong';
        }

       } //Delete Venue



} //The Venue's first closed


if(isset($_POST["actionForMember"]))
{
  //Data View in Data DTable
  if($_POST["actionForMember"] == 'fetch')
 {

  $query = "
  SELECT * FROM participants_mms ";
  if(isset($_POST["search"]["value"]))
  {
   // $query .= 'WHERE all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%" ';
       $query .= 'WHERE participant_affiliation LIKE "%'.$_POST["search"]["value"].'%"';
  }
  if(isset($_POST["order"]))
  {
   $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
  }
  else
  {
   $query .= 'ORDER BY id ASC ';
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
   $sub_array[] = $row["participant_affiliation"];
   $sub_array[] = $row["participant_email"];
   

   
   $editMemButton = '<button type="button" name="editMember" class="btn btn-primary btn-sm editMember" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit</button>';
   $deleteMemButton= '<button type="button" name="deleteMember" class="btn btn-danger btn-sm deleteMember" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';



   


   $sub_array[]=$editMemButton.' '.$deleteMemButton;


    

    $queryGetMeetingType = "SELECT * FROM meeting_type_mms ";
    $statementMeetingType = $connect->prepare($queryGetMeetingType);
    $statementMeetingType->execute();
    $resultMeetingType = $statementMeetingType->fetchAll();
   
    $output = '<fieldset><form method="post"  id="assignMemShip_form'.$row["id"].'">';


    foreach($resultMeetingType as $rowOfMeetingType)
    {

    $queryGetMemOf = "SELECT * FROM memberof_mms WHERE participants_id='".$row["id"]."'";
    $statementGetMemOf = $connect->prepare($queryGetMemOf);
    $statementGetMemOf->execute();
    $resultGetMemOf = $statementGetMemOf->fetchAll();

    $meetingTypeList=[];
    $participant_id=$row["id"];
    $participant_email=$row["participant_email"];

    foreach($resultGetMemOf as $rowGetMemOf)
    {
      $meetingTypeList[]=$rowGetMemOf["meetingType_id"];
    }
      


      $output .= '
          <div class="row">
            <div class="form-check form-check-inline">
              <label><input type="checkbox" name="memberOf[]"';

              if (in_array($rowOfMeetingType["id"], $meetingTypeList)){ 

                $output .='checked';
              }

              $output .=' class="meetingTypeList"  value="'.$rowOfMeetingType["id"].'"  data-memtype-id="'.$rowOfMeetingType["id"].'"/>&nbsp;'.$rowOfMeetingType["name"].'</label>

              </div>
              <input type="hidden" name="participant_id" value="'.$participant_id.'"/>
              <input type="hidden" name="participant_email" value="'.$participant_email.'"/>
           
          
          </div>';
    }
    $output.='
    </form></fieldset>
    ';
    $sub_array[]=$output;
   
   $data[] = $sub_array;
  }

  $output = array(
   "draw"    => intval($_POST["draw"]),
   "recordsTotal"  =>  $filtered_rows,
   "recordsFiltered" => get_agenda_records($connect, 'participants_mms'),
   "data"    => $data
  );
  echo json_encode($output);
 }
 //End of Data View in Data Table

         if($_POST["actionForMember"] == "Add" || $_POST["actionForMember"] == "Edit")
         {


            $participant_affiliation = $_POST["participant_affiliation"];
            $participant_email=$_POST["participant_email"];
            

            $isGuest=$_POST["isGuest"];

            $uparticipant_affiliation = $_POST["uparticipant_affiliation"];
            $uparticipant_email=$_POST["uparticipant_email"];
            

            $uisGuest=$_POST["uisGuest"];
            $emailNoCounter=0;
            
           
               if($_POST["actionForMember"] == "Add")

               {
                try{


                    
                    foreach ($participant_email as $key => $value) {

                      $queryForgettingMember="SELECT * FROM participants_mms WHERE participant_email='".$value."'";

                  $statementForgettingMember = $connect->prepare($queryForgettingMember);
                  $statementForgettingMember->execute();
                  $gelAllEmail = $statementForgettingMember->fetchAll();

                  $rowCount = $statementForgettingMember->rowCount();
                  if ($rowCount>0) {
                    $emailNoCounter++;
                  }
                  
                    }

                 

                  #Check Member already Exist or not
                  if ($emailNoCounter<1) {


                    
                  foreach ($participant_email as $key => $value) {


                $data = array(
                 ':participant_affiliation' => $participant_affiliation[$key],
                 ':participant_email'     => $value,
                 ':isGuest'            => $isGuest[$key]
                  );

              


                $query = "INSERT INTO participants_mms 
                (participant_affiliation,participant_email,isGuest) VALUES (:participant_affiliation,:participant_email,:isGuest)";

                $statement = $connect->prepare($query);

                $statementexe=$statement->execute($data);

                $lastId = $connect->lastInsertId();
                date_default_timezone_set("Asia/Dhaka");
                $create_date = date("Y-m-d h:i:sa");
                $unique = mt_rand(1000, 9999);
                $otp=$lastId.$unique;
                $role="Viewer";
                $verfication_code = md5(rand());

                if($statementexe)
                {
                  $data2 = array(
                  ':participant_email'     => $value,
                  ':verfication_code'     => $verfication_code,
                  ':role'     => $role,
                  ':participant_id'     => $lastId
                  );
                  
                  $query2 = "INSERT INTO user (user_email,verfication_code,role,participant_id) VALUES (:participant_email,:verfication_code,:role,:participant_id)";
                  $statement2 = $connect->prepare($query2);
                  $statementexe2=$statement2->execute($data2);

                  if($statementexe2){

                  $subject = 'Invitation to join GUB Meeting Management System';

                  $emailMessage =nl2br('

                    "This is a system generated email, don\'t send back any reply to this email"

                    Dear Sir/Madam,
                    ------------------------
                    This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="http://localhost/dash/verify-email.php?type=user&code='.$verfication_code.'" target="_blank"><b>link</b></a>

                      ------------------------


                    Regards,

                    Green University of Bangladesh (GUB).');
                    //send_email($participant_email,$subject,$emailMessage);

                      

                    $output = array(
                      'success'  => 'New Participant has been added',
                      'email'  => $participant_email,
                      'sub'=> $subject,
                    );

                  }else{
                    $output = array(
                   'error'     => true,);
                  }
                 }
                 else
                 {
                  $output = array(
                   'error'     => true,
                  );
                 }


                }

              }

                else{
                  $output = array(
                      'warning'  => 'Member already Exist, please try with new email',
                      
                    );
                }#End Check Member already Exist or not

                


              }catch(PDOException $e){
                $error= $e->getMessage();
                      $output = array(
                   'error'     => $error
                  );
              }
            }



             if($_POST["actionForMember"] == "Edit")
             {

              $data = array(
               ':participant_affiliation'   => $uparticipant_affiliation,
               ':participant_email'         => $uparticipant_email,
               ':meeting_type_id'           => $umeeting_type_id,
               ':isGuest'                   => $uisGuest,

               ':participant_id'    => $_POST["uparticipant_id"]
              );
              $query = "
              UPDATE participants_mms 
              SET participant_affiliation=:participant_affiliation,participant_email=:participant_email,meeting_id=:meeting_type_id,isGuest=:isGuest
              WHERE id = :participant_id
              ";
              $statement = $connect->prepare($query);
              if($statement->execute($data))
              {
               $output = array(
                'success'  => 'Participant has been updated Successfully',
               );
              }
             }
            
            echo json_encode($output);
          }



      //Fetch meeting type for Edit in Modal
      if($_POST["actionForMember"] == "fetchForEditMem")
       {
        $query = "SELECT * FROM participants_mms WHERE id = '".$_POST["participant_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {

          
          $output["participant_affiliation"] = $row["participant_affiliation"];
          $output["participant_email"] = $row["participant_email"];
          $output["meeting_type_id"] = $row["meeting_id"];
          $output["isGuest"] = $row["isGuest"];

          

          

          $output["participant_id"] = $row["id"];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Meber


      //Check Member Email
       if($_POST["actionForMember"] == "checkEmail")
       {
        $participant_email=$_POST["participant_email"];

        $query = "SELECT * FROM participants_mms WHERE participant_email = '".$participant_email."'";
        $statement = $connect->prepare($query);
        $statement->execute();


        if($statement->execute())
        {
          echo $countRecords = $statement->rowCount();

          
         
        }else{
            echo 'Something went wrong';
        }

       } //Check Member Email

       //Delete Member
       if($_POST["actionForMember"] == "deleteMember")
       {
        $query = "DELETE FROM participants_mms WHERE id = '".$_POST["participant_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
          echo 'Participant Deleted Successfully';

          
         
        }else{
            echo 'Something went wrong';
        }

       } //Delete Member


       //Update Membership
       if ($_POST["actionForMember"] == "assignMemberShip")


       {

        $memberOf=$_POST["memberOf"];
        $participant_id=$_POST["participant_id"];
        $participant_email=$_POST["participant_email"];

        $query="SELECT * FROM memberof_mms WHERE participants_id='".$_POST["participant_id"]."'";

        $statement = $connect->prepare($query);
        $statement->execute();

        $countRecords = $statement->rowCount();

        //echo json_encode($countRecords) ;


            if ($countRecords>0)
                      {
                        $sql1="SELECT * FROM memberof_mms WHERE participants_id = '".$participant_id."'";
                        $statement1=$connect->prepare($sql1);
                        $statement1->execute();
                        $result1=$statement1->fetchAll();

                        

                        foreach ($result1 as $result2)
                        {
                           
                            $update_value="DELETE  FROM memberof_mms WHERE participants_id=".$result2["participants_id"]."";
                            // $result=mysqli_query($conn,$update_value) or die("Query failed");
                            $statement=$connect->prepare($update_value);
                            $statement->execute();
                            
                          
                        }
                        foreach($memberOf as $meetingTypeList)
                        {
                          $query2 = "INSERT INTO memberof_mms  (meetingType_id,participant_email,participants_id) VALUES('".$meetingTypeList."','".$participant_email."','".$participant_id."')";
                          
                          // echo $query;
                          $statement2=$connect->prepare($query2);

                          $result=$statement2->execute() or die("Query failed");
                         }

                      }else{

                    foreach($memberOf as $meetingTypeList)
                     {
                      $query = "INSERT INTO memberof_mms  (meetingType_id,participant_email,participants_id) VALUES('".$meetingTypeList."','".$participant_email."','".$participant_id."')";
                      
                      
                      $statement=$connect->prepare($query);

                      $result=$statement->execute() or die("Query failed");
                     }
                    }
                 
             
             if($result)
             {
              echo json_encode('Membership Assigned Successfully') ;
              
             } else echo json_encode( 'Data not inserted');

       } //Update Membership






} //The Participant's first closed

?>