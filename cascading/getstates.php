<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "world";

$con = mysqli_connect($server, $username, $password, $dbname);

if (!$con) {
    die("Connection to this database failed due to " . mysqli_connect_error());
}

if (isset($_GET['countryId'])) {
    $countryId = $_GET['countryId'];
    $sql = "SELECT id, name FROM states WHERE country_id='$countryId'";
    $result = mysqli_query($con, $sql);
    $states = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $states[$row['id']] = $row['name'];
    }
    echo json_encode($states);
}
?>
