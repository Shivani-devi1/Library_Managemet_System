<?php
// Include the database connection
include 'db.php';

// Assuming the user is logged in and their ID is stored in the session
session_start();
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Get the resource ID and type from the query parameters
$resourceId = isset($_GET['id']) ? $_GET['id'] : null;
$resourceType = isset($_GET['type']) ? $_GET['type'] : null;

// Check if the user is logged in and both resource ID and type are provided
if ($userId && $resourceId && $resourceType) {
    // Insert the reservation into the reservations table
    $sql = "INSERT INTO reservations (user_id, resource_type, resource_id, reservation_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters: user_id as integer, resource_type as string, resource_id as integer
    $stmt->bind_param("isi", $userId, $resourceType, $resourceId);

    if ($stmt->execute()) {
        // Successfully reserved the resource
        echo "<p>Resource successfully reserved!</p>";
        echo "<p><a href='user_dashboard.php'>Back to userdashboard</a></p>";
    } else {
        // Failed to reserve the resource
        echo "<p>Failed to reserve the resource. Please try again later.</p>";
    }

    $stmt->close();
} else {
    // Missing parameters or user not logged in
    echo "<p>Invalid reservation request or you are not logged in. Please go back and try again.</p>";
}

$conn->close();
?>
