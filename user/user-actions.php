<?php
include('../database/dbconfig.php');

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
  $query = "
  SELECT * FROM all_meeting_mms";
  if(isset($_POST["search"]["value"]))
  {
   // $query .= 'WHERE all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR all_metting_mms.metting_title LIKE "%'.$_POST["search"]["value"].'%" 
   //    OR tbl_grade.grade_name LIKE "%'.$_POST["search"]["value"].'%" ';
  	   $query .= ' WHERE meeting_title LIKE "%'.$_POST["search"]["value"].'%"';
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
   //$sub_array[] = $row["id"];
  
   // $sub_array[] = $row["grade_name"];
   //$sub_array[] = '<a href="agenda.php?code='.$row['id'].'" class="btn btn-outline-success btn-sm" target="_blank"><i class="fas fa-eye"></i> View Agenda</a>';
   //$viewMeetingButton= '<button type="button" name="view_meeting" class="badge badge-info view_meeting" id="'.$row["id"].'"><i class="fas fa-eye"></i> View</button>';
  // $editMeetingButton = '<button type="button" name="edit_meeting" class="badge badge-primary edit_meeting" id="'.$row["id"].'"><i class="fas fa-edit"></i>Edit</button>';
  // $deleteMeetingButton= '<button type="button" name="delete_meeting" class="badge badge-danger  delete_meeting" id="'.$row["id"].'"><i class="fas fa-trash-alt"></i> Delete</button>';
   //$sub_array[]=$viewMeetingButton.' '.$editMeetingButton.' '.$deleteMeetingButton;
   $sub_array[]= '<div class="card">
   <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <span style="margin-bottom:5px"><i class="fa fa-comments" aria-hidden="true"></i> <b>Meeting Title:</b> <i></i>'.$row["meeting_title"].'</span>
                  </div>
                  <div class="col-md-4">
                    
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <p  style="margin-bottom:5px"><i class="fa fa-clock" aria-hidden="true"></i> <b>Start Time:</b>'.$row["meeting_date"].', '.$row["meeting_stime"].'</p>
                  </div>
                  <div class="col-md-6">
                    <p  style="margin-bottom:5px"><i class="fa fa-clock" aria-hidden="true"></i> <b>Expected End Time:</b> '.$row["meeting_date"].', '.$row["meeting_etime"].'</p>
                  </div>
                  
                </div>

              

            <div class="row">
              <div class="col-md-6">
                <p style="margin-bottom:5px"><i class="fa fa-id-card" aria-hidden="true"></i><b> Venue:</b>
                  <span>'.$row["meeting_venue"].'</span></p>
                </div>
            </div>
            <div class="row">
                  <div class="col-md-8">
                    <i class="fa fa-info-circle" aria-hidden="true"></i><b> N.B. </b>
                    <small>'.$row["meeting_description"].'</small>
                  </div>
                  
                    
                  </div>
                </div>
            <div class="row">
              <div class="col-md-12">
                
                <button type="button" name="view_agenda" class="btn btn-outline-success btn-sm view_agenda" id="'.$row["id"].'"><i class="fas fa-eye"></i> View Agenda</button>
                
              </div>
            </div>


        </div></div>';//Final ed of card div
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
    $meeting_description= $_POST["meeting_description"];
    $meeting_venue=$_POST["meeting_venue"];
    $meeting_date=$_POST["meeting_date"];
    $meeting_stime=$_POST["meeting_stime"];
    $meeting_etime= $_POST["meeting_etime"];
    
    $create_date='x';


  
   if($_POST["action"] == "Add")

   {
    try{
    $data = array(
     ':meeting_title'   => $meeting_title,
     ':meeting_type_id'   => $meeting_type_id,
     ':meeting_description'   => $meeting_description,
     ':meeting_venue'   => $meeting_venue,
     ':meeting_date'   => $meeting_date,
     ':meeting_stime' => $meeting_stime,
     ':meeting_etime'    => $meeting_etime
     
     
    );
    $query = "INSERT INTO all_meeting_mms 
    (meeting_title, meeting_type_id, meeting_description, meeting_venue, meeting_date, meeting_stime, meeting_etime) VALUES (:meeting_title,:meeting_type_id,:meeting_description,:meeting_venue,:meeting_date,:meeting_stime,:meeting_etime)";

    $statement = $connect->prepare($query);

    $statementexe=$statement->execute($data);

    if($statementexe)
    {

      $output = array(
       'success'  => 'Meeting has been created successfully',
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
          $query2 = "DELETE FROM agenda_mms WHERE meeting_id = '".$_POST["meeting_id"]."'";
          $statement2 = $connect->prepare($query2);

          if($statement2->execute()){

            $query3 = "DELETE FROM decision_mms WHERE agenda_id = '".$_POST["agenda_id"]."'";
            $statement3 = $connect->prepare($query3);

            if($statement3->execute()){

              echo 'Agenda Delete Successfully';
            }else{
            echo 'Something went wrong';
          }
            
          }else{
            echo 'Something went wrong';
          }
         
        }else{
            echo 'Something went wrong';
        }

       } //Delete Meeting

if($_POST["action"] == 'fetchAgenda')
 {
  $query = "
  SELECT * FROM agenda_mms WHERE
  meeting_id = '".$_POST["meeting_id"]."'";
  $statement = $connect->prepare($query);
  if($statement->execute())
  {
   $result = $statement->fetchAll();
   $sl = 1;
   $output = '
   <div class="row justify-content-center">
   <div class="col-md-9">
     <table class="table table-striped table-bordered">
     <thead>
     <th>Agenda.No.</th>
     <th class="text-center">Agenda Title</th>
     </thead>
   ';
   foreach($result as $row)
   {
    $output .= '

      <tr>
      <td>'.$sl.'</td>
      <td>'.$row["agenda_title"].'</td>

      </tr>
      
     
    ';
    $sl++;
   }
   $output .= '</table>
    </div></div>';
   echo $output;
  }
 }

 



} //The first if closed

?>