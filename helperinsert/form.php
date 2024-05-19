<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Contact Form</h2>
            <form id="contactForm" onsubmit="addContact(event)">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<div id="employees"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    loadEmployees(); // Load employees when the page loads

    // Event listener for form submission
    $('form').on('submit', function(event) {
        event.preventDefault();
        addContact();
    });
});

function loadEmployees() {
    var tableName = 'contacts'; // Use the table name you want to fetch data from
    $.ajax({
        url: 'backend.php',
        type: 'post',
        data: { action: 'fetch', name1: tableName },
        success: function(response) {
            console.log(response); // Debugging: Print the response to the console
            try {
                var employees = JSON.parse(response);
                var html = '<table class="table table-bordered" style="background-color: #f9f9f9;"><thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th></tr></thead><tbody>';
                employees.forEach(function(employee) {
                    html += '<tr><td>' + employee.id + '</td><td>' + employee.name + '</td><td>' + employee.email + '</td><td>' + employee.message + '</td></tr>';
                });
                html += '</tbody></table>';
                $('#employees').html(html);
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}

function addContact() {
    var tableName = 'contacts'; // Table name
    var name = $('#name').val();
    var email = $('#email').val();
    var message = $('#message').val();

    $.ajax({
        url: 'backend.php',
        type: 'post',
        data: { action: 'add', table: tableName, name: name, email: email, message: message },
        success: function(response) {
            console.log(response); // Debugging: Print the response to the console
            loadEmployees();
            $('#name').val(''); // Clear the name field
            $('#email').val(''); // Clear the email field
            $('#message').val(''); // Clear the message field
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
}


</script>
</body>
</html>
