<?php
include('database/dbconfig.php');

$output = ''; 

if(isset($_POST["action"]))
{
	 
     //Data View in Data DTable
	if($_POST["action"] == 'fetch')
 {
  $meetingId=$_POST["code"];

  //$queryForMeetingTitle = "SELECT * FROM all_meeting_mms WHERE id='$meetingID'";
   // $query = "
  // SELECT * FROM all_metting_mms 
  // INNER JOIN meeting_type_mms 
  // ON meeting_type_mms.id = all_metting_mms.meeting_type_id ";
  $query = "
  SELECT * FROM agenda_mms WHERE meeting_id='".$meetingId."' AND (";
  if(isset($_POST["search"]["value"]))
  {
   // $query .= 'WHERE all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%" ';
  	   $query .= ' agenda_title LIKE "%'.$_POST["search"]["value"].'%"';
  }
  $query .= ')';
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
   
   $sub_array[] = $row["id"];
   $sub_array[] = $row["agenda_title"];
   
 
   
   $editAgendaButton = '<button type="button" name="edit_agenda" class="badge badge-primary edit_agenda" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit</button>';
   $deleteAgendaButton= '<button type="button" name="delete_agenda" class="badge badge-danger  delete_agenda" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';
   $sub_array[]= $editAgendaButton. ' ' . $deleteAgendaButton;


   // $sub_array[] = '<button type="button" name="delete_teacher" class="btn btn-danger btn-sm delete_teacher" id="'.$row["id"].'">Delete</button>';
   $query2="SELECT * FROM decision_mms WHERE agenda_id='".$row["id"]."'";
   $statement2 = $connect->prepare($query2);
   $statement2->execute();
   $result2 = $statement2->fetchAll();
    foreach($result2 as $row2)
      { 
          
          if ($row2["decisions"]=="") 
            {
              
              $sub_array[]='<button type="button" class="btn btn-primary addDecisionBtn" id="'.$row["id"].'" data-toggle="modal" data-target="#createDecision">Add Discussion & Decision</button>';
              
            }else{
              $sub_array[]=$row2["discussion"];
              $sub_array[]=$row2["decisions"];
              $sub_array[]=$row2["responsible_person"];
              
              $editDecisionButton = '<button type="button" name="edit_decision" class="badge badge-primary  edit_decision" id="'.$row2["id"].'"><i class="fas fa-edit"></i>Edit</button>';
              $sub_array[]= $editDecisionButton;
            }
          
          
      }



   $data[] = $sub_array;
  }

  $output = array(
   "draw"    => intval($_POST["draw"]),
   "recordsTotal"  =>  $filtered_rows,
   "recordsFiltered" => get_total_records($connect, 'agenda_mms',$meetingId),
   "data"    => $data
  );
  echo json_encode($output);
 }
 //End of View Agenda in Data DTable



      //Add Agenda Start
      if($_POST["action"] == 'Add' || $_POST["action"] == "Edit")
       {


          $meeting_agenda = $_POST["meeting_agenda"];
          $meetingId=$_POST["meeting_code"];




        
         if($_POST["action"] == "Add")

         {
          try{
          $data = array(
           ':agenda_title'   => $meeting_agenda,
           ':meeting_id'     => $meetingId
          
           
           
          );

          $query = "INSERT INTO agenda_mms 
          (agenda_title,meeting_id) VALUES (:agenda_title,:meeting_id)";

          $statement = $connect->prepare($query);

          $statementexe=$statement->execute($data);
          $lastId = $connect->lastInsertId();

          if($statementexe)
          {
            $data2 = array(
           ':agenda_id'     => $lastId
            );
            $query2 = "INSERT INTO decision_mms (agenda_id) VALUES (:agenda_id)";
            $statement2 = $connect->prepare($query2);
            $statementexe2=$statement2->execute($data2);

            if($statementexe2){

              $output = array(
               'success'  => 'Agenda Added Successfully',
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
           ':agenda_title'    => $meeting_agenda,
           
           ':agenda_id'    => $_POST["agenda_id"]
          );
          $query = "
          UPDATE agenda_mms
          SET agenda_title = :agenda_title
          WHERE id = :agenda_id
          ";
          $statement = $connect->prepare($query);
          if($statement->execute($data))
          {
           $output = array(
            'success'  => 'Agenda Edited Successfully'
           );
          }
         }
        
        echo json_encode($output);
      }
      //Add Agenda End

      //Fetch Agenda for Edit in Modal
      if($_POST["action"] == "fetchForEditAgenda")
       {
        $query = "SELECT * FROM agenda_mms WHERE id = '".$_POST["agenda_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {
          $output['agenda_title'] = $row['agenda_title'];

          $output['agenda_id'] = $row['id'];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Agenda

        if($_POST["action"] == "deleteAgenda")
       {
        $query = "DELETE FROM agenda_mms WHERE id = '".$_POST["agenda_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
          $query2 = "DELETE FROM decision_mms WHERE agenda_id = '".$_POST["agenda_id"]."'";
          $statement2 = $connect->prepare($query2);
          if($statement2->execute()){
            echo 'Agenda Delete Successfully';
          }else{
            echo 'Something went wrong';
          }
         
        }else{
            echo 'Something went wrong';
        }

       }



}


if (isset($_POST['decisionAction'])) 
{
          //Add Decision Start
      if($_POST["decisionAction"] == 'addDecision' || $_POST["decisionAction"] == "editDecision")
       {


          $agendaId = $_POST["agendaId"];
          $agenda_discussion=$_POST["agenda_discussion"];
          $agenda_decision=$_POST["agenda_decision"];
          $responsible_person=$_POST["responsible_person"];




        
         if($_POST["decisionAction"] == "addDecision")

         {
          try{
          $data = array(
            ':discussion'   => $agenda_discussion,
           ':decisions'   => $agenda_decision,
           ':responsible_person'=> $responsible_person,
           ':agendaId'     => $agendaId
          
           
           
          );

          $query = "UPDATE decision_mms SET discussion = :discussion,decisions = :decisions, responsible_person= :responsible_person WHERE agenda_id = :agendaId";

          $statement = $connect->prepare($query);

          $statementexe=$statement->execute($data);
          


          if($statementexe)
          {
            $output = array(
               'success'  => 'Decision Added Successfully',
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

      if($_POST["decisionAction"] == "editDecision")

         {
          $data = array(
            ':discussion'   => $agenda_discussion,
           ':decisions'   => $agenda_decision,
           ':responsible_person'=> $responsible_person,
           ':decision_id'     => $_POST['decision_id']
          );
          
          $query = "UPDATE decision_mms SET discussion = :discussion,decisions = :decisions, responsible_person= :responsible_person WHERE id = :decision_id";

          $statement = $connect->prepare($query);
          if($statement->execute($data))
          {
           $output = array(
            'success'  => 'Edited Successfully'
           );
          }
         }



         
        
        echo json_encode($output);
      }
      //Add Decision End


      //Fetch Decison for Edit in Modal
      if($_POST["decisionAction"] == "fetchForEditDecision")
       {
        $query = "SELECT * FROM decision_mms WHERE id = '".$_POST["decision_id"]."'";
        $statement = $connect->prepare($query);
        if($statement->execute())
        {
         $result = $statement->fetchAll();
         foreach($result as $row)
         {
          $output['discussion'] = $row['discussion'];
          $output['decisions'] = $row['decisions'];
          $output['responsible_person'] = $row['responsible_person'];

          $output['decision_id'] = $row['id'];
         }
         echo json_encode($output);
        }
       }
       //End Edit Fetch Decision

}
?>