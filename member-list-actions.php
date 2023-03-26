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
      $output2 .= '<option value="'.$row["id"].'" selected>'.$row["member_affiliation"].'('.$row["member_email"].')</option>';


      }

      // $query2 = "
      // SELECT * FROM allmemlist_mms LEFT OUTER JOIN memberlist_mms ON (allmemlist_mms.id=memberlist_mms.membership_id) WHERE memberlist_mms.membership_id IS NULL";


      $query2 = "SELECT  *
      FROM    allmemlist_mms
      WHERE   id NOT IN (SELECT membership_id FROM memberlist_mms WHERE mem_list_category_id={$_POST['memListcategory_id']})";

      $statement2 = $connect->prepare($query2);
      $statement2->execute();
      $result2 = $statement2->fetchAll();
      foreach($result2 as $row2)
      {
      $output2 .= '<option value="'.$row2["id"].'">'.$row2["member_affiliation"].'</option>';

      
      
      }

     }

      
      echo $output2;
   }

//Fetch All Member

    if($_POST["actionForMemlist"] == 'fetchAll')
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
      FROM    allmemlist_mms";
      $statement = $connect->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $row)
      {
      $output2 .= '<option value="'.$row["id"].'">'.$row["member_affiliation"].'('.$row["member_email"].')</option>';


      }

      // $query2 = "
      // SELECT * FROM allmemlist_mms LEFT OUTER JOIN memberlist_mms ON (allmemlist_mms.id=memberlist_mms.membership_id) WHERE memberlist_mms.membership_id IS NULL";




     }

      
      echo $output2;
   }





       //Update Membership
       if ($_POST["actionForMemlist"] == "memListUpdate")


       {

        $meeting_member_list=$_POST["hidden_meeting_member_list"];
        $memListcategory_id=$_POST["memListcategory_id"];
        

        $query="SELECT * FROM memberlist_mms WHERE mem_list_category_id={$memListcategory_id}  ";

        $statement = $connect->prepare($query);
        $statement->execute();

        $countRecords = $statement->rowCount();

        //echo json_encode($countRecords) ;


            if ($countRecords>0)
                      {
                        $sql1="SELECT * FROM memberlist_mms WHERE mem_list_category_id={$memListcategory_id}";
                        $statement1=$connect->prepare($sql1);
                        $statement1->execute();
                        $result1=$statement1->fetchAll();

                        

                        foreach ($result1 as $result2)
                        {
                           
                            $update_value="DELETE  FROM memberlist_mms WHERE mem_list_category_id={$memListcategory_id}";
                            // $result=mysqli_query($conn,$update_value) or die("Query failed");
                            $statement=$connect->prepare($update_value);
                            $statement->execute();
                            
                          
                        }
                        $hidden_meeting_member_list=explode(",",$meeting_member_list);

                        foreach($hidden_meeting_member_list as $meetingMemList)
                        {
                          $query2 = "INSERT INTO memberlist_mms  (membership_id,mem_list_category_id) VALUES('".$meetingMemList."','".$memListcategory_id."')";
                          
                          // echo $query;
                          $statement2=$connect->prepare($query2);

                          $result=$statement2->execute() or die("Query failed");
                         }

                      }else{
                        $hidden_meeting_member_list=explode(",",$meeting_member_list);

                    foreach($hidden_meeting_member_list as $meetingMemList)
                     {
                      $query2 = "INSERT INTO memberlist_mms  (mem_list_category_id,membership_id) VALUES('".$memListcategory_id."','".$meetingMemList."')";
                      
                      
                      $statement=$connect->prepare($query2);

                      $result=$statement->execute() or die("Query failed");
                     }
                    }
                 
             
             if($result)
             {
              echo json_encode('Membership Assigned Successfully') ;
              
             } else echo json_encode( 'Data not inserted');

       } //Update Membership




      // //Update Membership
      //  if ($_POST["actionForMemlist"] == "memListUpdate")


      //  {

      //   $meeting_member_list=$_POST["hidden_meeting_member_list"];
      //   $memListcategory_id=$_POST["memListcategory_id"];
        

        
      //               $hidden_meeting_member_list=explode(",",$meeting_member_list);

      //               foreach($hidden_meeting_member_list as $meetingMemList)
      //                {
      //                 $query2 = "INSERT INTO memberlist_mms  (mem_list_category_id,membership_id) VALUES('".$memListcategory_id."','".$meetingMemList."')";
                      
                      
      //                 $statement=$connect->prepare($query2);

      //                 $result=$statement->execute() or die("Query failed");
      //                }
                    
                 
             
      //        if($result)
      //        {
      //         echo json_encode('Membership Assigned Successfully') ;
              
      //        } else echo json_encode( 'Data not inserted');

      //  } //Update Membership



}

if(isset($_POST["actionAddMlistType"]))
{
  //Data View in Data DTable
	if($_POST["actionAddMlistType"] == 'fetch')
 {
  // $query = "
  // SELECT * FROM all_metting_mms 
  // INNER JOIN meeting_type_mms 
  // ON meeting_type_mms.id = all_metting_mms.meeting_type_id ";
  $query = "
  SELECT * FROM member_list_category_mms ";
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
   
   $editMTypeButton = '<button type="button" name="editMlistType" class="btn btn-primary btn-sm editMlistType" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit list Name</button>';
   $deleteMTypeButton= '<button type="button" name="deleteMlistType" class="btn btn-danger btn-sm deleteMlistType" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';
   $editMemberList = '<a href="edit-member-list.php?id='.$row['id'].'" class="btn btn-outline-primary btn-sm" target="_blank"><i class="fas fa-edit"></i>Edit Member list</a>';

   // $editMemberList= '<button type="button" name="deleteMlistType" class="btn btn-danger btn-sm deleteMlistType" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';

   $sub_array[]=$editMTypeButton.' '.$deleteMTypeButton.' '.$editMemberList;
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

 if($_POST["actionAddMlistType"] == 'Add' || $_POST["actionAddMlistType"] == "Edit")
 {


    $memListType_name = $_POST["memListType_name"];
    $meeting_member_list=$_POST["hidden_meeting_member_list"];
  
    
  


  
if($_POST["actionAddMlistType"] == "Add")

   {
    try{


    $data = array(
     ':memListType_name'   => $memListType_name
     
     
    );
    $query = "INSERT INTO member_list_category_mms 
    (name) VALUES (:memListType_name)";

    $statement = $connect->prepare($query);

    $statementexe=$statement->execute($data);
    $lastId = $connect->lastInsertId();

    if($statementexe)
    {
              
            $hidden_meeting_member_list=explode(",",$meeting_member_list);

            foreach($hidden_meeting_member_list as $meetingMemList)
              {
                $query2 = "INSERT INTO memberlist_mms  (mem_list_category_id,membership_id) VALUES('".$lastId."','".$meetingMemList."')";
                      
                      
                 $statement=$connect->prepare($query2);

                  $result=$statement->execute() or die("Query failed");
              }





      $output = array(
       'success'  => 'Member list has been created successfully',
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



  if($_POST["actionAddMlistType"] == "Edit")
   {

    $data = array(
     ':memListType_name'   => $memListType_name,
     ':memListType_id'    => $_POST["memListType_id"]
    );
    $query = "
    UPDATE member_list_category_mms 
    SET name=:memListType_name
    WHERE id = :memListType_id
    ";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
     $output = array(
      'success'  => 'Member list name updated Successfully',
     );
    }
   }
  
  echo json_encode($output);
}



//Fetch meeting type for Edit in Modal
      if($_POST["actionAddMlistType"] == "fetchForEditMlistType")
       {
        $query = "SELECT * FROM member_list_category_mms WHERE id = '".$_POST["memListType_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {

          
          $output["memListType_name"] = $row["name"];
          

          

          $output['memListType_id'] = $row['id'];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Meeting Type

       //Delete Meeting Type
       if($_POST["actionAddMlistType"] == "deleteMlistType")
       {
        $query = "DELETE FROM member_list_category_mms WHERE id = '".$_POST["memListType_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {

          $sql1="SELECT * FROM memberlist_mms WHERE mem_list_category_id={$_POST["memListType_id"]}";
                        $statement1=$connect->prepare($sql1);
                        $statement1->execute();
                        $result1=$statement1->fetchAll();

                        

                        foreach ($result1 as $result2)
                        {
                           
                            $update_value="DELETE  FROM memberlist_mms WHERE mem_list_category_id={$_POST["memListType_id"]}";
                            // $result=mysqli_query($conn,$update_value) or die("Query failed");
                            $statement=$connect->prepare($update_value);
                            $statement->execute();
                            
                          
                        }

          echo 'Member list Deleted Successfully';

          
         
        }else{
            echo 'Something went wrong';
        }

       } //Delete Meeting Type



} //The first if closed





if(isset($_POST["actionForMember"]))
{
  //Data View in Data DTable
  if($_POST["actionForMember"] == 'fetch' )
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

  if($_POST['memListCategoryId'] != '' && isset($_POST['memListCategoryId']))
    {
     $query .= ' AND participant_affiliation = "'.$_POST['memListCategoryId'].'"';
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
    $output.='<div class="text-center"> <button type="submit" class="btn btn-sm btn-primary assignMemshipBtn" name="assignMemshipBtn" id="'.$row["id"].'" value="Save">Save</button>

    </div>
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
            
           
               if($_POST["actionForMember"] == "Add")

               {
                try{

                  $queryForgettingMember="SELECT * FROM participants_mms WHERE participant_email='".$participant_email."'";

                  $statementForgettingMember = $connect->prepare($queryForgettingMember);
                  $statementForgettingMember->execute();
                  $gelAllEmail = $statementForgettingMember->fetchAll();
                  $rowCount = $statementForgettingMember->rowCount();

                  #Check Member already Exist or not
                  if ($rowCount<=0) {
                    
                  


                $data = array(
                 ':participant_affiliation' => $participant_affiliation,
                 ':participant_email'     => $participant_email,
                 ':isGuest'            => $isGuest
                 
                 
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
                  ':participant_email'     => $participant_email,
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
                    send_email($participant_email,$subject,$emailMessage);

                      

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


                }else{
                  $output = array(
                      'warning'  => 'This Member is already Exist',
                      
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
               ':participant_affiliation'   => $participant_affiliation,
               ':participant_email'         => $participant_email,
               ':meeting_type_id'           => $meeting_type_id,
               ':isGuest'                   => $isGuest,

               ':participant_id'    => $_POST["participant_id"]
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
              echo json_encode('List has been updated Successfully') ;
              
             } else echo json_encode( 'Data not inserted');

       } //Update Membership






} //The Participant's first closed

?>