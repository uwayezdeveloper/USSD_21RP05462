<?php
// Include your database connection configuration here
$host = "localhost";
$dbname = "project";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["approve"])) {
    $roomId = $_POST["room_id"];

    try {
        // Update the status to 'Approved' in the pending_rooms table
        $updateStatusSQL = "UPDATE pending_rooms SET action = 'Approved' WHERE room_id = :roomId";
        $updateStatusStmt = $pdo->prepare($updateStatusSQL);
        $updateStatusStmt->bindParam(':roomId', $roomId);
        $updateStatusStmt->execute();

        echo "Room has been approved.";

        // Additional actions after approval, if needed
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid access.";
}
?>
