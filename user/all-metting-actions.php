<?php
include('../database/dbconfig.php');

$output = ''; 

if(isset($_POST["action"]))
{
  //Data View in Data DTable
	if($_POST["action"] == 'fetch')
 {

  $query = "
  SELECT * FROM all_meeting_mms WHERE meeting_date > CURDATE()";
  if(isset($_POST["search"]["value"]))
  {

  	   $query .= 'AND meeting_title LIKE "%'.$_POST["search"]["value"].'%"';
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

   $sub_array[] = $row["id"];
   $sub_array[] = $row["meeting_title"];
   $sub_array[] = $row["meeting_description"];
  
   
  
  $sub_array[]= '<a href="mom.php?code='.$row['id'].'" class="btn btn-outline-info btn-sm" target="_blank"><i class="fas fa-eye"></i> View Minutes</a>';


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