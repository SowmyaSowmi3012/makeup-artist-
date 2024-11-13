<?php
// Start the session
session_start();

// Check if the admin session is set
if (!isset($_SESSION['admin'])) {
    // If not, redirect to login page
    header('Location: login.php');
    exit();
}

// Include the database connection file
include('db_connection.php');

// Fetch the admin username from the session
$adminUsername = $_SESSION['admin'];

// Fetch appointments from the database
$query = "SELECT * FROM appointments";
$appointments_result = mysqli_query($conn, $query);

// Check if query was successful
if (!$appointments_result) {
    die("Error: " . mysqli_error($conn));
}

// Fetch contact messages from the database
$contact_messages_query = "SELECT * FROM contact_messages";
$contact_messages_result = mysqli_query($conn, $contact_messages_query);

// Check if query was successful
if (!$contact_messages_result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        /* Add some basic styles for hiding/showing sections */
        #appointments-section, #contact-messages {
            display: none;
        }
    </style>
    <script>
        function toggleSection(sectionId) {
            var section = document.getElementById(sectionId);
            // Toggle visibility of the selected section
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block'; // Show
            } else {
                section.style.display = 'none'; // Hide
            }
        }
    </script>
</head>
<body>

    <div class="dashboard-container">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Welcome, <strong><?php echo htmlspecialchars($adminUsername); ?></strong>!</p>

        <nav>
            <ul>
                <li><a href="javascript:void(0);" onclick="toggleSection('appointments-section')">Manage Appointments</a></li>
                <li><a href="javascript:void(0);" onclick="toggleSection('contact-messages')">View Contact Messages</a></li>
            </ul>
        </nav>

        <h2>Admin Panel</h2>
        <p>Here you can manage appointments, view client messages, and access other admin features.</p>

        <!-- Appointments Section (Initially Hidden) -->
        <div id="appointments-section">
            <h3>Appointments</h3>
            <table>
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Appointment Type</th>
                        <th>Created At</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch each row from the result and display in the table
                    if (mysqli_num_rows($appointments_result) > 0) {
                        while ($appointment = mysqli_fetch_assoc($appointments_result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($appointment['client_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['client_email']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['client_phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['appointment_date']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['appointment_time']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['appointment_type']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['created_at']) . "</td>";
                            echo "<td>" . htmlspecialchars($appointment['additional_message']) . "</td>"; // Message column
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No appointments found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Contact Messages Section (Initially Hidden) -->
        <div id="contact-messages">
            <h3>Contact Messages</h3>
            <?php if (mysqli_num_rows($contact_messages_result) > 0): ?>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Received At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($contact_messages_result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['message']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No contact messages found.</p>
            <?php endif; ?>
        </div>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
