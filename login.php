<?php
session_start();

// Include database connection
include('db_connection.php');

// Define admin username and password for comparison
$adminUsername = 'admin';  // Admin username
$adminPassword = 'admin123';  // Use the actual password in plaintext for initial hashing, will be hashed in the db

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if the username exists in the database
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Check if the username matches admin
    if ($username == $adminUsername) {
        // Verify the password for the admin user
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['admin'] = $user['username'];

            // Redirect to the dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            // Invalid username or password
            $error = "Invalid username or password";
        }
    } else {
        // If someone tries to log in with a non-admin account
        $error = "You are not authorized to log in.";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login.css">
    <style>
        .return-home-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fbceb5;
            color: black;
            text-align: center;
            text-decoration: none;
            border-radius: 40px;
            margin-top: 20px;
        }

        .return-home-btn:hover {
            background-color:#FDEBD0;
        }
    </style>
</head>
<body style="background-image: url(mjj3.jpg);" class="img js-fullheight">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Login</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <form action="login.php" method="POST" class="signin-form">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <?php
                            if (isset($error)) {
                                echo "<p style='color: red; text-align: center;'>$error</p>";
                            }
                            ?>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                        </form>
                        <!-- Button to return to homepage -->
                        <a href="index.html" class="return-home-btn">Return to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>