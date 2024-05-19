<?php
$pdo = new PDO("mysql:host=localhost;dbname=world1", "root", "");

// Check for action parameter
if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'fetch':
            if (isset($_POST['name1'])) {
                $table = $_POST['name1'];
                viewData($table);
            } else {
                echo json_encode(['error' => 'Table name not provided']);
            }
            break;
            case 'add':
                insertData($_POST['table'], $_POST);
                break;
            case 'update':
                updateEmployee($_POST['id'], $_POST['name'], $_POST['position'], $_POST['salary']);
                break;
            case 'delete':
                deleteEmployees($_POST['id']);
                break;
    }
}

function viewData($table, $conditions = []) {
    $pdo = new PDO("mysql:host=localhost;dbname=world1", "root", "");

    // Validate the table name to prevent SQL injection
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        echo json_encode(['error' => 'Invalid table name']);
        return;
    }

    // Construct the SQL query
    $conditionPart = $conditions ? "WHERE " . implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($conditions))) : "";
    $sql = "SELECT * FROM $table $conditionPart";

    $stmt = $pdo->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $pdo->errorInfo()[2]);
    }

    // Bind the parameters if there are conditions
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    // Execute the statement and fetch the results
    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } else {
        echo json_encode(['error' => $stmt->errorInfo()[2]]);
    }
}
function insertData($table, $data) {
    try {
        // Establish a new PDO connection
        $pdo = new PDO("mysql:host=localhost;dbname=world1", "root", "");

        // Validate the table name to prevent SQL injection
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
            throw new Exception('Invalid table name');
        }

        // Construct the SQL query
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);

        // Execute the statement with the data
        if ($stmt->execute(array_values($data))) {
            echo "New record created successfully in table $table";
        } else {
            echo "Error: " . implode(" ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "PDO error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "General error: " . $e->getMessage();
    }
}


?>
