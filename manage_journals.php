<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (isset($_POST['add_journal'])) {
        $title = $_POST['title'];
        $publisher = $_POST['publisher'];
        $year = $_POST['year'];

        $sql = "INSERT INTO journals (title, publisher, year) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $title, $publisher, $year);
        $stmt->execute();
        echo "Journal added successfully.";
    }

  
    if (isset($_POST['edit_journal'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $publisher = $_POST['publisher'];
        $year = $_POST['year'];

        $sql = "UPDATE journals SET title=?, publisher=?, year=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $title, $publisher, $year, $id);
        $stmt->execute();
        echo "Journal updated successfully.";
    }


    if (isset($_POST['delete_journal'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM journals WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo "Journal deleted successfully.";
    }

   
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            color: #333;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        form {
            margin: 20px 0;
        }
        label {
            display: block;
            margin: 8px 0 4px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
        .manage-section {
            margin: 20px 0;
        }
        .manage-section div {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .manage-section h3 {
            margin: 0;
        }
        .manage-section p {
            margin: 4px 0;
        }
        .manage-section form {
            display: inline-block;
            margin-right: 10px;
        }
        .manage-section .edit-form input {
            display: block;
            width: auto;
            margin-bottom: 5px;
        }
        .manage-section a {
            color: #0275d8;
            text-decoration: none;
        }
        .manage-section a:hover {
            text-decoration: underline;
        }
        .logout-link {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Journals</h1>
        <div class="logout-link">
           
        </div>

        
        <h2>Add New Journal</h2>
        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
            <label for="publisher">Publisher:</label>
            <input type="text" name="publisher" id="publisher">
            <label for="year">Year:</label>
            <input type="number" name="year" id="year">
            <button type="submit" name="add_journal">Add Journal</button>
        </form>

        

        <h2>Manage Journals</h2>
            <?php
          
            $sql = "SELECT * FROM journals";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>Publisher: " . htmlspecialchars($row['publisher']) . "</p>";
                echo "<p>Year: " . htmlspecialchars($row['year']) . "</p>";
                echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                     
                      </form>";
                echo "<form method='POST' class='edit-form' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                        <input type='text' name='title' value='" . htmlspecialchars($row['title']) . "' required>
                        <input type='text' name='publisher' value='" . htmlspecialchars($row['publisher']) . "'>
                        <input type='number' name='year' value='" . htmlspecialchars($row['year']) . "'>
                        <button type='submit' name='edit_journal'>Edit</button>    <button type='submit' name='delete_journal'>Delete</button>
                      </form>";
                echo "</div>";
            }
            ?>
 <p><a href="logout.php">Logout</a></p>
       
        </div>
       
    </div>
</body>
</html>