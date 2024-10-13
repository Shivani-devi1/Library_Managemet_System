<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
   
    if (isset($_POST['add_audiobook'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $year = $_POST['year'];
        $url = isset($_POST['url']) ? $_POST['url'] : '';

        $sql = "INSERT INTO audiobooks (title, author, genre, year, url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssis', $title, $author, $genre, $year, $url);
        $stmt->execute();
        echo "Audiobook added successfully.";
    }

    if (isset($_POST['edit_audiobook'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $year = $_POST['year'];
        $url = isset($_POST['url']) ? $_POST['url'] : '';

        $sql = "UPDATE audiobooks SET title=?, author=?, genre=?, year=?, url=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssisi', $title, $author, $genre, $year, $url, $id);
        $stmt->execute();
        echo "Audiobook updated successfully.";
    }

    if (isset($_POST['delete_audiobook'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM audiobooks WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo "Audiobook deleted successfully.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AudioBooks</title>
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
        <h1>Audio Books</h1>
        <div class="logout-link">
           
        </div>


        <h2>Add New Audiobook</h2>
        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>
            <label for="genre">Genre:</label>
            <input type="text" name="genre" id="genre">
            <label for="year">Year:</label>
            <input type="number" name="year" id="year">
            <label for="url">URL:</label>
            <input type="text" name="url" id="url" required>
            <button type="submit" name="add_audiobook">Add Audiobook</button>
        </form>

        

           
            <h2>Manage Audiobooks</h2>
            <?php
            // Display audiobooks
            $sql = "SELECT * FROM audiobooks";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>Author: " . htmlspecialchars($row['author']) . "</p>";
                echo "<p>Genre: " . htmlspecialchars($row['genre']) . "</p>";
                echo "<p>Year: " . htmlspecialchars($row['year']) . "</p>";
                echo "<p>URL: <a href='" . htmlspecialchars($row['url']) . "'>" . htmlspecialchars($row['url']) . "</a></p>";
                echo "<form method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                      
                      </form>";
                echo "<form method='POST' class='edit-form' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                        <input type='text' name='title' value='" . htmlspecialchars($row['title']) . "' required>
                        <input type='text' name='author' value='" . htmlspecialchars($row['author']) . "' required>
                        <input type='text' name='genre' value='" . htmlspecialchars($row['genre']) . "'>
                        <input type='number' name='year' value='" . htmlspecialchars($row['year']) . "'>
                        <input type='text' name='url' value='" . htmlspecialchars($row['url']) . "' required>
                        <button type='submit' name='edit_audiobook'>Edit</button>   <button type='submit' name='delete_audiobook'>Delete</button>
                      </form>";
                echo "</div>";
            }
            ?>
            <p><a href="logout.php">Logout</a></p>
        </div>
        
    </div>
</body>
</html>