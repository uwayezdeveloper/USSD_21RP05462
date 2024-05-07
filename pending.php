<div>
<?php
include 'admindash.php';

?>
</div>
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

// Fetch pending room details from the database
try {
    $fetchPendingRoomsSQL = "SELECT *
                             FROM pending_rooms,rooms
                            where pending_rooms.room_id =rooms.id
                             and pending_rooms.action = 'Pending'";
    $fetchPendingRoomsStmt = $pdo->query($fetchPendingRoomsSQL);
    $pendingRooms = $fetchPendingRoomsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Process approve button action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["approve"])) {
    $pendingId = $_POST["pending_id"];
    try {
        $updatePendingStatusSQL = "UPDATE pending_rooms SET action = 'Approved' WHERE pending_id = :pendingId";
        $updatePendingStatusStmt = $pdo->prepare($updatePendingStatusSQL);
        $updatePendingStatusStmt->bindParam(':pendingId', $pendingId);
        $updatePendingStatusStmt->execute();
        ?><html>
       
        <meta http-equiv="refresh" content="2"> 
        <?php
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Rooms</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        th, td {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container col-lg-8 d-md-block bg-light sidebar">
<div class="position-sticky">
    <h1>Pending Rooms</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th>
                <th>Block Number</th>
                <th>Price</th>
                <th>Booked Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingRooms as $room): ?>
                <tr>
                    <td><?= $room['pending_id'] ?></td>
                    <td><?= $room['name'] ?></td>
                    <td><?= $room['block'] ?></td>
                    <td><?= $room['price'] ?></td>
                    <td><?= $room['booked_date'] ?></td>
                    <td><?= $room['action'] ?></td>
                    <td>
                        <?php if ($room['action'] === 'Pending'): ?>
                            <form method="post">
                                <input type="hidden" name="pending_id" value="<?= $room['pending_id'] ?>">
                                <button type="submit" name="approve" class="btn btn-success">Approve</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
