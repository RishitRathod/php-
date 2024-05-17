<?php 

$conn = mysqli_connect("localhost","root","","student");

if(isset($_POST['checking_view']))
{
    $stud_id = $_POST['stud_id'];
    $result_array = [];

    $query = "SELECT * FROM students WHERE id='$stud_id' ";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0)
    {
        foreach($query_run as $row)
        {
            array_push($result_array, $row);
        }
        header('Content-type: application/json');
        echo json_encode($result_array);
    }
    else
    {
        echo $return = "No Record Found.!";
    }
}

?>