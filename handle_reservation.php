<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $resource_id = $_POST['resource_id'];
    $resource_type = $_POST['resource_type'];
    $action = $_POST['action'];

    if ($action === 'return') {
      
        $sql = "DELETE FROM reservations WHERE user_id=? AND resource_id=? AND resource_type=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iis', $user_id, $resource_id, $resource_type);
        if ($stmt->execute()) {
            $message = "Reservation returned successfully.";
            $message_type = "success";
        } else {
            $message = "Failed to return reservation. Please try again.";
            $message_type = "error";
        }
    } elseif ($action === 'renew') {
      
        $new_reservation_date = date('Y-m-d', strtotime('+7 days'));
        $sql = "UPDATE reservations SET reservation_date=? WHERE user_id=? AND resource_id=? AND resource_type=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('siss', $new_reservation_date, $user_id, $resource_id, $resource_type);
        if ($stmt->execute()) {
            $message = "Reservation renewed successfully.";
            $message_type = "success";
        } else {
            $message = "Failed to renew reservation. Please try again.";
            $message_type = "error";
        }
    } else {
        $message = "Invalid action.";
        $message_type = "error";
    }
} else {
    $message = "Invalid request method.";
    $message_type = "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 2em;
            color: #2c3e50;
        }

        .message {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .message.success {
            color: #27ae60;
        }

        .message.error {
            color: #e74c3c;
        }

        a {
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #2980b9;
            color: #fff;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1c5985;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reservation Status</h1>
        <p class="message <?php echo htmlspecialchars($message_type); ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
        <p><a href="user_dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
