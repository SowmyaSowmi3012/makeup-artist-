<?php
// Initialize variables to avoid errors when displaying them before form submission
$name = $email = $phone = $date = $time = $message = "";
$response_message = "";

// Database connection
$conn = new mysqli("localhost", "root", "", "makeup_artist");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $message = htmlspecialchars($_POST['message']);
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    // Prepare SQL query to insert form data into the database
    $stmt = $conn->prepare("INSERT INTO appointments (client_name, client_email, client_phone, appointment_date, appointment_time, additional_message) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $message);

    // Check if the query was successful
    if ($stmt->execute()) {
        $response_message = "Appointment booked successfully!";
    } else {
        $response_message = "Error booking appointment. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar1</title>
    <link rel="stylesheet" href="styles.css">
    <script src="index.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,800;1,400;1,500;1,900&display=swap" 
    rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.11.2/css/all.css" 
    integrity="sha384-zrnmn8R8KkWl12rAZFt4yKjxplaDaT7/EUkKm7AovijfrQItFWR7O/JJn4DAa/gx" crossorigin="anonymous">
    
</head>
</head>
<body style="background-color: black;">
    <div style="display: flex; justify-content: center;">
        <img src="mjr2.jpeg" class="logom" class="navbar-brand" style="margin: 0;" href="#"></img>
        <h1 style="text-align:center; color:#B79541; line-height: 126px; margin: 0 32px; font-size: 42px;"> Manjula J Ramakrishna Makeup and Hair Artistry</h1>
    </div>
    <header>
        
        <nav style="margin: 0 auto;">
            
            <ul class="nav_links" id="nav_links">
                <!-- <div class="prime-nav">-->
                <li><a href="index.html">Homepage</a></li>
                <li><a href="makeup.html">Makeup</a></li>
                <li><a href="hairstyles.html">Hairstyles</a></li>
                <li><a href="sareedrapping.html">Saree drapping</a></li>
                <li><a href="aboutus.html">About us</a></li>
                <li><a href="contactus.html">Contact us</a></li>
                <li><a href="appointment.php">Appointment</a></li>   
                </ul>

        </nav> 
          <div id="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
       </header>
       <h2 style="text-align:center; color: burlywood;">Book an Appointment</h2>
    
    <!-- Display the form -->
    <form action="appointment.php" method="POST" id="appointmentForm">
        <label for="name" style="color: burlywood;">Name</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Your Name" required>

        <label for="email" style="color: burlywood;">Email</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Your Email" required>

        <label for="phone" style="color: burlywood;">Phone</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Your Phone Number" required>

        <label for="date" style="color: burlywood;">Preferred Date</label>
<input type="date" id="date" name="date" value="<?php echo $tomorrow; ?>" min="<?php echo $tomorrow; ?>" required>

<label for="time" style="color: burlywood;">Preferred Time</label>
<input type="time" id="time" name="time" min="10:00" max="18:00" required onchange="validateTime()">
<p id="timeError" style="color: red; display: none;">Please select a time between 10:00 AM and 6:00 PM.</p>

        <label for="message"style="color: burlywood;">Additional Information:</label>
        <textarea id="message" name="message" placeholder="Enter any additional information"><?php echo $message; ?></textarea>

        <button type="submit">Book Appointment</button>
    </form>

    <!-- Display response message -->
    <p id="response-message"><?php echo $response_message; ?></p>
    <script>
    document.getElementById('date').addEventListener('input', function () {
        const selectedDate = new Date(this.value);
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);

        // If the selected date is before tomorrow, reset the input
        if (selectedDate < tomorrow) {
            alert("Please select a date starting from tomorrow.");
            this.value = '';
        }
    });
    function validateTime() {
    const timeInput = document.getElementById('time');
    const timeError = document.getElementById('timeError');
    const selectedTime = timeInput.value;

    if (selectedTime < "10:00" || selectedTime > "18:00") {
        timeError.style.display = "block"; // Show error message
        timeInput.value = ""; // Clear the invalid time
    } else {
        timeError.style.display = "none"; // Hide error message
    }
}
</script>
</body>
</html>
