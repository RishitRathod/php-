<?php
function dbConnect() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "world1";
    
    $con = new mysqli($server, $username, $password, $dbname);
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    
    return $con;
}

function insertData($table, $data) {
    $con = dbConnect();
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $types = str_repeat('s', count($data));
    $stmt->bind_param($types, ...array_values($data));

    if ($stmt->execute()) {
        echo "New record created successfully in table $table";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}

function updateData($table, $data, $conditions) {
    $con = dbConnect();
    $setPart = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
    $conditionPart = implode(" AND ", array_map(fn($key) => "$key = ?", array_keys($conditions)));
    $sql = "UPDATE $table SET $setPart WHERE $conditionPart";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $types = str_repeat('s', count($data) + count($conditions));
    $stmt->bind_param($types, ...array_merge(array_values($data), array_values($conditions)));

    if ($stmt->execute()) {
        echo "Record updated successfully in table $table";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}

function deleteData($table, $conditions) {
    $con = dbConnect();
    $conditionPart = implode(" AND ", array_map(fn($key) => "$key = ?", array_keys($conditions)));
    $sql = "DELETE FROM $table WHERE $conditionPart";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    $types = str_repeat('s', count($conditions));
    $stmt->bind_param($types, ...array_values($conditions));

    if ($stmt->execute()) {
        echo "Record deleted successfully from table $table";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}

function viewData($table, $conditions = []) {
    $con = dbConnect();
    $conditionPart = $conditions ? "WHERE " . implode(" AND ", array_map(fn($key) => "$key = ?", array_keys($conditions))) : "";
    $sql = "SELECT * FROM $table $conditionPart";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $con->error);
    }

    if ($conditions) {
        $types = str_repeat('s', count($conditions));
        $stmt->bind_param($types, ...array_values($conditions));
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Error: " . $stmt->error;
        return [];
    }

    $stmt->close();
    $con->close();
}
?>
