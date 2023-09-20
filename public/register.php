<?php
// Check if the _method field exists in the POST data
if (isset($_POST['_method'])) {
    $method = strtoupper($_POST['_method']);

    // Handle the request based on the value of _method
    if ($method === 'PUT') {
        // Handle PUT request (if needed)
        // Your code here...
        echo "Unsupported method: PUT for registration";
    } elseif ($method === 'DELETE') {
        // Handle DELETE request (if needed)
        // Your code here...
        echo "Unsupported method: DELETE for registration";
    } else {
        // Handle other cases or show an error
        echo "Unsupported method: $method";
    }
} else {
    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "admin";
    $password = "admin123";
    $dbname = "innovix labs";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input from the registration form (with security measures)
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Hash the password (for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user already exists (based on email)
    $emailCheckQuery = "SELECT * FROM users WHERE email = '$email'";
    $emailCheckResult = $conn->query($emailCheckQuery);

    if ($emailCheckResult->num_rows > 0) {
        // Email already exists, handle accordingly (e.g., show an error message)
        echo "Email already exists. Please choose a different email address.";
    } else {
        // Insert user data into the database
        $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
        
        if ($conn->query($insertQuery) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
    // After the database query execution
if ($conn->query($insertQuery) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $insertQuery . "<br>" . $conn->error;
}


    // Close the database connection
    $conn->close();
}
?>
