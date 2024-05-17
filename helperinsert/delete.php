<?php
require 'help.php';

if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];

    deleteData($table, $id);

    // Redirect to the view page after deletion
    header('Location: view_data.php');
    exit();
} else {
    echo "Invalid request";
}



function deleteData($table, $conditions) {
    $con = dbConnect();

    // Prepare the statement with placeholders for conditions
    $sql = "DELETE FROM $table WHERE id=$conditions";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    // Bind parameters if conditions are given
  
    if ($stmt->execute()) {
        echo "Record deleted successfully from table $table";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}

?>


