<?php
require_once 'helper.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Automatically collect all POST data
    $data = $_POST;

    // Specify the table name based on the value of the 'contacts' key in POST data
    if ($_POST['contacts'] === 'contacts') {
        $table = 'contacts'; // You can change this dynamically if needed
    } else {
        $table = 'contacts2';
    }
    
    // Remove the 'contacts' key from data array since it's not a column in the table
    unset($data['contacts']);

    // Call the helper function to insert data into the specified table
    insertData($table, $data);
}
?>
