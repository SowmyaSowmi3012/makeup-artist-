<?php
// Include database connection
include('db_connection.php');

// Define the admin username and password
$username = 'admin';  // Admin username
$password = 'admin123';  // The password you want to use for the admin (plaintext)

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Query to insert the admin user into the users table
$query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

// Execute the query and check if successful
if (mysqli_query($conn, $query)) {
    echo "Admin user added successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
