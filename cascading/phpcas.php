<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "world";

$con = mysqli_connect($server, $username, $password, $dbname);

if (!$con) {
    die("Connection to this database failed due to " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cascading DropDown</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha384-CSC6KT6x6o6L0lV7Vtb8Jaz3OVx3D38EFpDo9e6PqLfBiLx91t8uJ1ACy7FeVG7H" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h2>Cascading Dropdown Example</h2>
        <form class="form-group">
            <label for="country">Country: </label>
            <select id="country" name="country" class="form-select">
                <option value="">Select Country</option>
                <?php
                $sql = "SELECT id, name FROM countries";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // echo '<option value="' . $row['id'] . ' text='.$row['name']"></option>';
                        echo '<option value="' . $row['id'] . '" text="' . $row['name'] . '">' . $row['name'] . '</option>';

                    }
                }
                ?>
            </select>
            <br><br>
            <label for="state">State: </label>
            <select id="state" name="state" class="form-select">
                <option value="">Select State</option>
            </select>
            <br><br>
            <label for="city">City: </label>
            <select id="city" name="city" class="form-select">
                <option value="">Select City</option>
            </select>
        </form>
    </div>

    <script>
    $(document).ready(function(){
        $('#country').change(function(){
            var country_id = $(this).val();
            $.ajax({
                url: "getStates.php",
                method: "GET",
                data: {countryId: country_id},
                dataType: "json",
                success: function(data){
                    $('#state').html('<option value="">Select State</option>');
                    $.each(data, function(key, value){
                        $('#state').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        });

        $('#state').change(function(){
            var state_id = $(this).val();
            $.ajax({
                url: "getCities.php",
                method: "POST",
                data: {stateId: state_id},
                dataType: "json",
                success: function(data){
                    $('#city').html('<option value="">Select City</option>');
                    $.each(data, function(key, value){
                        $('#city').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
