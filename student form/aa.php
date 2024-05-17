<?php
if(isset($_POST['Save'])){
    include 'dbconnect.php';

    $name = $_POST['name'];
    $sem = $_POST['sem'];
    $email = $_POST['email'];
    $cgpa = $_POST['cgpa'];
    $department = $_POST['fav_language'];
    $date = $_POST['date'];

    $sql = "INSERT INTO student_data (name, sem, email, cgpa, department, dob)
    VALUES ('$name','$sem','$email','$cgpa','$department','$date')";
    $conn->exec($sql);
    $conn = null;
    echo json_encode(['status' => 'success']);
    exit;
}

if(isset($_POST['delete'])){
    include 'dbconnect.php';
    $v = $_POST['ide'];
    $sql = "DELETE FROM student_data WHERE student_id=$v";
    $conn->exec($sql);
    $conn = null;
    echo json_encode(['status' => 'success']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container{
            display: flex;
            align-items: end;
        }
        #add{
            display: flex;
            align-items: end;
            justify-content: end;
        }
    </style>
</head>
<body>
 <div class="container">
    <h1>Students list</h1>
    <button id="add" name="add">Add Students</button>
 </div>
<br><br>

<div id="form-container" style="display:none;">
    <form id="student-form" action="student_details.php" method="post">
        <h1>Student Form</h1>
        <label for="name">Enter name:</label>
        <input type="text" name="name" id="name" required>
        <label for="sem">Enter sem:</label>
        <input type="number" name="sem" id="sem">
        <label for="email">Enter email:</label>
        <input type="email" name="email" id="email">
        <label for="cgpa">Enter cgpa:</label>
        <input type="text" name="cgpa" id="cgpa">
        <label for="date">Select dob:</label>
        <input type="date" name="date" id="date">
        <div>
            Select department: <br>
            <input type="radio" id="ICT" name="fav_language" value="ICT">      
            <label for="ICT">ICT</label><br>
            <input type="radio" id="IT" name="fav_language" value="IT">
            <label for="IT">IT</label><br>
            <input type="radio" id="CE" name="fav_language" value="CE">
            <label for="CE">CE</label>
        </div>
        <input type="submit" name="Save" id="save" value="Save">
        <button type="button" id="cancel">Cancel</button>
    </form>
</div>

<div id="students-list"></div>

<script>
$(document).ready(function(){
    function fetchStudents() {
        $.ajax({
            url: 'fetch_students.php',
            method: 'GET',
            success: function(data) {
                $('#students-list').html(data);
            }
        });
    }

    fetchStudents();

    $('#add').click(function(){
        $('#form-container').show();
    });

    $('#cancel').click(function(){
        $('#form-container').hide();
    });

    $('#student-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'student_details.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    fetchStudents();
                    $('#form-container').hide();
                }
            }
        });
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).data('id');
        $.ajax({
            url: 'student_details.php',
            method: 'POST',
            data: { ide: id, delete: true },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status === 'success') {
                    fetchStudents();
                }
            }
        });
    });
});
</script>
</body>
</html>
