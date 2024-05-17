<?php
if(isset($_POST['Update'])){
    include 'dbconnect.php';
    $v = $_POST['ide'];
    $name=$_POST['name'];
    $sem=$_POST['sem'];
    $email=$_POST['email'];
    $cgpa=$_POST['cgpa'];
    $department=$_POST['fav_language'];
    $date=$_POST['date'];
   


$sql=" UPDATE `student_data` SET 
  `name`='$name',
  `sem`='$sem',
  `email`='$email',
  `cgpa`='$cgpa',
  `department`='$department',
  `dob`='$date' WHERE student_id=$v";


 $conn->exec($sql);
      echo "Record deleted successfully";
      header("Location:Student_details.php");
       exit;
    echo $sem;
    $conn = null;
}