<?php
require_once 'helper.php';

$contacts = viewData('contacts');
$messages = viewData('contacts2');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script>
        function handleUpdate(id, table) {
            window.location.href = `update.php?id=${id}&table=${table}`;
        }

        function deleteData(table, contact) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = `delete.php?id=${contact.id}&table=${table}`;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Contact Details</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['name']); ?></td>
                        <td><?= htmlspecialchars($contact['email']); ?></td>
                        <td><?= htmlspecialchars($contact['message']); ?></td>
                        <td>
                             <button class="btn btn-danger btn-sm" onclick="deleteData('contacts', <?= htmlspecialchars(json_encode($contact)); ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Messages</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?= htmlspecialchars($message['name']); ?></td>
                        <td><?= htmlspecialchars($message['country']); ?></td>
                        <td><?= htmlspecialchars($message['state']); ?></td>
                        <td><?= htmlspecialchars($message['department']); ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="deleteData('contacts2', <?= htmlspecialchars(json_encode($message)); ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
