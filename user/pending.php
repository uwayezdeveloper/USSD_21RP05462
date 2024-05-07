<?php
session_start();
// Include your database connection configuration here
$host = "localhost";
$dbname = "project";
$username = "root";
$password = "";
$id=$_GET['id'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $roomId = $_GET["id"];

    try {
        $pdo->beginTransaction();

        // Fetch room details from the rooms table
        $fetchRoomSQL = "SELECT name, block, price FROM rooms WHERE id = :roomId FOR UPDATE";
        $fetchRoomStmt = $pdo->prepare($fetchRoomSQL);
        $sessid= $_SESSION['user_id'];   
        // Insert the room into the pending_rooms table with additional information
        $insertPendingSQL = "INSERT INTO pending_rooms (room_id, booked_date, action,user_id) VALUES (:roomId, CURRENT_TIMESTAMP, 'Pending',:idd)";
$insertPendingStmt = $pdo->prepare($insertPendingSQL);



        // Insert the room into the pending_rooms table
        $insertPendingStmt->bindParam(':roomId', $roomId);
        $insertPendingStmt->bindParam(':idd', $sessid);
        $insertPendingStmt->execute();

        // Commit the transaction
        $pdo->commit();

        echo "Booking request sent. Waiting for admin approval.";
        header("refresh:2;url=rooms.php");
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle the case when someone tries to access pending.php directly without a valid room id
    echo "Invalid access.";
}
?>

