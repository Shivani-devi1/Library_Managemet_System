<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Library System</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <li><a href="admin.php">Admin Dashboard</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<main>
