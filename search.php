<?php
include 'db.php';


$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchQuery = "%$query%";


$sqlBooks = "SELECT 'book' AS type, id, title, author, year, genre, NULL AS url FROM books WHERE title LIKE ? OR author LIKE ?";
$sqlEbooks = "SELECT 'ebook' AS type, id, title, author, year, genre, url FROM ebooks WHERE title LIKE ? OR author LIKE ?";
$sqlJournals = "SELECT 'journal' AS type, id, title, NULL AS author, year, NULL AS genre, NULL AS url FROM journals WHERE title LIKE ?";
$sqlAudiobooks = "SELECT 'audiobook' AS type, id, title, author, year, genre, url FROM audiobooks WHERE title LIKE ? OR author LIKE ?";


$statements = [
    ['sql' => $sqlBooks, 'params' => [$searchQuery, $searchQuery]],
    ['sql' => $sqlEbooks, 'params' => [$searchQuery, $searchQuery]],
    ['sql' => $sqlJournals, 'params' => [$searchQuery]],
    ['sql' => $sqlAudiobooks, 'params' => [$searchQuery, $searchQuery]]
];

$results = [];

foreach ($statements as $stmtData) {
    $stmt = $conn->prepare($stmtData['sql']);
    $stmt->bind_param(str_repeat('s', count($stmtData['params'])), ...$stmtData['params']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}


usort($results, function($a, $b) {
    return strcmp($a['type'], $b['type']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Search Results</h1>
    <?php
    foreach ($results as $row) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<p>Author: " . htmlspecialchars($row['author']) . "</p>";
        echo "<p>Year: " . htmlspecialchars($row['year']) . "</p>";
        echo "<p>Genre: " . htmlspecialchars($row['genre']) . "</p>";
        if ($row['url']) {
            echo "<p>URL: <a href='" . htmlspecialchars($row['url']) . "'>" . htmlspecialchars($row['url']) . "</a></p>";
        }
        echo "<p><a href='reserve.php?id=" . $row['id'] . "&type=" . htmlspecialchars($row['type']) . "'>Reserve</a></p>";
        echo "</div>";
    }
    ?>
</body>
</html>
