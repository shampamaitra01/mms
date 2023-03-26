<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=greenedu_meeting_management","root","");

$base_url = "";

function get_total_records($connect, $table_name,$meetingId)
{
 $query = "SELECT * FROM $table_name WHERE meeting_id={$meetingId}";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

function load_meeting_types($connect)
{
 $query = "
 SELECT * FROM meeting_type_mms ORDER BY id ASC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
 }
 return $output;
}

function load_member_list($connect)
{
 $query = "
 SELECT * FROM memberlist_mms ORDER BY id ASC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["id"].'" selected>'.$row["member_affiliation"].'</option>';
 }
 return $output;
}

function load_venues($connect)
{
 $query = "
 SELECT * FROM venues_mms ORDER BY id ASC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["id"].'">'.$row["venue_name"].'</option>';
 }
 return $output;
}

  function getMettingCode($meetingCode)
  {
    $query = "SELECT * FROM meeting_mms 
    WHERE id = '$meetingCode'";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row)
    {
      return $row['id'];
    }
  }
  function get_agenda_records($connect, $table_name)
  {
   $query = "SELECT * FROM $table_name";
   $statement = $connect->prepare($query);
   $statement->execute();
   return $statement->rowCount();
  }


  function get_member_of($connect,$participants_id){
    $queryGetMemOf = "SELECT * FROM memberof_mms WHERE participants_id='".$participants_id."'";
    $statementGetMemOf = $connect->prepare($queryGetMemOf);
    $statementGetMemOf->execute();
    $resultGetMemOf = $statementGetMemOf->fetchAll();
  

    $meetingTypeList=[];

    foreach($resultGetMemOf as $rowGetMemOf)
    {
      $meetingTypeList[]=$rowGetMemOf["meetingType_id"];
    }
   
  }

function get_attendance_percentage($connect, $student_id)
{
 $query = "
 SELECT 
  ROUND((SELECT COUNT(*) FROM tbl_attendance 
  WHERE attendance_status = 'Present' 
  AND student_id = '".$student_id."') 
 * 100 / COUNT(*)) AS percentage FROM tbl_attendance 
 WHERE student_id = '".$student_id."'
 ";

 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  if($row["percentage"] > 0)
  {
   return $row["percentage"] . '%';
  }
  else
  {
   return 'NA';
  }
 }
}

function Get_student_name($connect, $student_id)
{
 $query = "
 SELECT student_name FROM tbl_student 
 WHERE student_id = '".$student_id."'
 ";

 $statement = $connect->prepare($query);

 $statement->execute();

 $result = $statement->fetchAll();

 foreach($result as $row)
 {
  return $row["student_name"];
 }
}

function Get_student_grade_name($connect, $student_id)
{
 $query = "
 SELECT tbl_grade.grade_name FROM tbl_student 
 INNER JOIN tbl_grade 
 ON tbl_grade.grade_id = tbl_student.student_grade_id 
 WHERE tbl_student.student_id = '".$student_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['grade_name'];
 }
}

function Get_student_teacher_name($connect, $student_id)
{
 $query = "
 SELECT tbl_teacher.teacher_name 
 FROM tbl_student 
 INNER JOIN tbl_grade 
 ON tbl_grade.grade_id = tbl_student.student_grade_id 
 INNER JOIN tbl_teacher 
 ON tbl_teacher.teacher_grade_id = tbl_grade.grade_id 
 WHERE tbl_student.student_id = '".$student_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["teacher_name"];
 }
}

function Get_grade_name($connect, $grade_id)
{
 $query = "
 SELECT grade_name FROM tbl_grade 
 WHERE grade_id = '".$grade_id."'
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row["grade_name"];
 }
}

?>