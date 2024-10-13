<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM reservations WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$reservations = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2.5em;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
        }

        a {
            color: #2980b9;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            margin: 20px 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        label {
            font-size: 1.1em;
            color: #333;
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            width: 100%;
            max-width: 300px;
            margin: 0;
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
            margin-left: 10px;
        }

        button:hover {
            background-color: #1c5985;
        }

        .reservation {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fafafa;
        }

        .reservation p {
            margin: 5px 0;
        }

        .reservation form {
            margin-top: 10px;
            text-align: center;
        }

        .reservation button {
            margin: 0 5px;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }

            input[type="text"] {
                width: 100%;
            }

            button {
                width: 100%;
                box-sizing: border-box;
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Dashboard</h1>
      
        <form action="search.php" method="GET">
            <label for="query">Search:</label>
            <input type="text" name="query" id="query" required>
            <button type="submit">Search</button>
        </form>
        <h2>My Reservations</h2>
        <?php
        while ($reservation = $reservations->fetch_assoc()) {
            $resource_id = $reservation['resource_id'];
            $resource_type = $reservation['resource_type'];

            // Fetch resource details based on type
            switch ($resource_type) {
                case 'book':
                    $sqlResource = "SELECT * FROM books WHERE id=?";
                    break;
                case 'ebook':
                    $sqlResource = "SELECT * FROM ebooks WHERE id=?";
                    break;
                case 'journal':
                    $sqlResource = "SELECT * FROM journals WHERE id=?";
                    break;
                case 'audiobook':
                    $sqlResource = "SELECT * FROM audiobooks WHERE id=?";
                    break;
                default:
                    $sqlResource = "";
            }

            if ($sqlResource) {
                $stmtResource = $conn->prepare($sqlResource);
                $stmtResource->bind_param('i', $resource_id);
                $stmtResource->execute();
                $resource = $stmtResource->get_result()->fetch_assoc();

                echo "<div class='reservation'>";
                echo "<p><strong>Resource Type:</strong> " . htmlspecialchars(ucfirst($resource_type)) . "</p>";
                echo "<p><strong>Title:</strong> " . htmlspecialchars($resource['title']) . "</p>";
                if (isset($resource['author'])) {
                    echo "<p><strong>Author:</strong> " . htmlspecialchars($resource['author']) . "</p>";
                }
                if (isset($resource['publisher'])) {
                    echo "<p><strong>Publisher:</strong> " . htmlspecialchars($resource['publisher']) . "</p>";
                }
                echo "<p><strong>Year:</strong> " . htmlspecialchars($resource['year']) . "</p>";
                if (isset($resource['url'])) {
                    echo "<p><strong>URL:</strong> <a href='" . htmlspecialchars($resource['url']) . "'>" . htmlspecialchars($resource['url']) . "</a></p>";
                }
                echo "<p><strong>Reservation Date:</strong> " . htmlspecialchars($reservation['reservation_date']) . "</p>";
                
                // Add Return and Renew buttons
                echo "<form action='handle_reservation.php' method='POST'>";
                echo "<input type='hidden' name='resource_id' value='" . htmlspecialchars($resource_id) . "'>";
                echo "<input type='hidden' name='resource_type' value='" . htmlspecialchars($resource_type) . "'>";
                echo "<button type='submit' name='action' value='return'>Return</button>";
                echo "<button type='submit' name='action' value='renew'>Renew</button>";
                echo "</form>";
                
                echo "</div>";
            }
        }
        ?>
          <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
