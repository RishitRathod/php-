<?php
include 'dbconnect.php';
$sql = 'SELECT * FROM student_data';
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll();

echo '<div class="container" style="display:flex; justify-content:center; ">
<div class="col-md-8">
    <div class="complaints-table" style="text-align:center;">
        <br>
        <table class="table table-hover" style="width:850px; margin-left:-80px;">
            <thead border="4">
            <tr>
                <th style="background-color:#b3d9ff;">ID</th>
                <th style="background-color:#b3d9ff;">Name</th>
                <th style="background-color:#b3d9ff;">Sem</th>
                <th style="background-color:#b3d9ff;">Email</th>
                <th style="background-color:#b3d9ff;">Cgpa</th>
                <th style="background-color:#b3d9ff;">Department</th>
                <th style="background-color:#b3d9ff;">Dob</th>
                <th style="background-color:#b3d9ff;">Action</th>
                </tr>
            </thead>
            <tbody  border="4">';

foreach($students as $row) {
    echo "<tr>";
    echo "<td>{$row["student_id"]}</td>";
    echo "<td>{$row["name"]}</td>";
    echo "<td>{$row["sem"]}</td>";
    echo "<td>{$row["email"]}</td>";
    echo "<td>{$row["cgpa"]}</td>";
    echo "<td>{$row["department"]}</td>";
    echo "<td>{$row["dob"]}</td>";
    echo('<td>');
    // echo('<a class="btn btn-info"  href="edit_student.php?id='.$row['student_id'].'">');
    // echo('edit');
    // echo('</a>');
    echo('  <form action="student_details.php" method="post">');  
    echo('<input type="hidden" name="ide" id="ide" value="' . $row['student_id'] . '">');
    echo('<input type="hidden" name="name" id="name" value="' . $row['name'] . '">');
    echo('<input type="hidden" name="sem" id="sem" value="' . $row['sem'] . '">');
    echo('<input type="hidden" name="email" id="email" value="' . $row['email'] . '">');
    echo('<input type="hidden" name="cgpa" id="cgpa" value="' . $row['cgpa'] . '">');
    echo('<input type="hidden" name="department" id="department" value="' . $row['department'] . '">');
    echo('<input type="hidden" name="dob" id="dob" value="' . $row['dob'] . '">');
    echo(' <input type="submit" name="Update" id="edit" value="edit">');
    echo('   <input type="submit" name="delete" id="delete" value="delete">');
    echo('</form>');
 echo('</td>');
    echo "</tr>";
}

echo '</tbody></table></div></div></div>';
?>
