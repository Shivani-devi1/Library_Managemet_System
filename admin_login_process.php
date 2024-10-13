<?php
session_start();
include 'db.php';


$username = $_POST['username'];
$password = $_POST['password'];


$sql = "SELECT * FROM admins WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    
   
    if ($password === $admin['password']) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Invalid password. <a href='admin_login.php'>Try again</a>";
    }
} else {
    echo "Admin not found. <a href='admin_login.php'>Try again</a>";
}
?>
