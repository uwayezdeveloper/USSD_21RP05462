<?php
session_start();

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

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    

    try {
        // Retrieve data from pending_rooms where user_id is equal to the logged-in user's ID and action is "Approved"
        $fetchApprovedRoomsSQL = "SELECT * FROM pending_rooms WHERE user_id = :userId AND action = 'Approved'";
        $fetchApprovedRoomsStmt = $pdo->prepare($fetchApprovedRoomsSQL);
        $fetchApprovedRoomsStmt->bindParam(':userId', $userId);
        $fetchApprovedRoomsStmt->execute();

        $approvedRooms = $fetchApprovedRoomsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the retrieved data
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Approved Rooms</title>
            <!-- Include Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container mt-4">
            <h1>Approved Rooms</h1>
            <?php if (count($approvedRooms) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($approvedRooms as $room): ?>
                        <li class="list-group-item">
                            Room ID: <?php echo $room['room_id']; ?>, Booked Date: <?php echo $room['booked_date']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No approved rooms found for the logged-in user.</p>
            <?php endif; ?>
        </div>
        <!-- Include Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "User not logged in.";
}
?>
<h3><a a href="userdash.php">back</a></h3>