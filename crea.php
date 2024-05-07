<?php
// Database connection
$host = "localhost"; // Your host name
$dbname = "project"; // Your database name
$username = "root"; // Your database username
$password = ""; // Your database password
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $sex = $_POST["sex"];      
    $location = $_POST["loc"];
    $password = $_POST["password"];
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // $hashedPassword = md5($password);

    // Prepare SQL statement
    $sql = "INSERT INTO users (`name`, `email`, `number`, `sex`, `location`, `password`)  VALUES (:name, :email, :tel, :sex, :location, :password)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':password', $password);

    // Execute the query
    try {
        $stmt->execute();
        echo "Record inserted successfully. loading....";
        header("refresh:2;url=home.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
