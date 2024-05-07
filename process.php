<?php
// Database connection
$host = "localhost"; // Your host name
$dbname = "your_database_name"; // Your database name
$username = "your_username"; // Your database username
$password = "your_password"; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($_POST["login"] == "Unlock") {
        // Your authentication logic for regular users
        // Use $pdo for database queries
        // Redirect to process2.php for regular users
        header("Location: process2.php");
        exit;
    } elseif ($_POST["login"] == "Unlock as Admin") {
        // Your authentication logic for admin
        // Use $pdo for database queries
        // Redirect to process1.php for admin
        header("Location: process1.php");
        exit;
    }
}
?>
