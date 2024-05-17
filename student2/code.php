<!-- Step 3: Create a file named code.php inside ajax-crud and paste the below code: -->

<?php

$conn = mysqli_connect("localhost","root","","student");

if(isset($_POST['checking_add']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $class = $_POST['class'];
    $section = $_POST['section'];

    $query = "INSERT INTO students (fname,lname,class,section) VALUES ('$fname','$lname','$class','$section')";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo $return  = "Successfully Stored";
    }
    else
    {
        echo $return  = "Something Went Wrong.!";
    }
}

?>