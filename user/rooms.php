<?php
include 'userdash.php';
?>
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

// Function to retrieve rooms from the database excluding pending or approved rooms
function getAvailableRooms() {
    global $pdo;

    try {
        $stmt = $pdo->query("SELECT * FROM rooms r WHERE NOT EXISTS (SELECT 1 FROM pending_rooms p WHERE p.room_id = r.id AND p.action IN ('Pending', 'Approved'))");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Example usage
$rooms = getAvailableRooms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room List</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Room List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Room ID</th>
                <th>Room Name</th>
                <th>Block Number</th>
                <th>Price per Month</th>
                <th>Number of Beds</th>
                <th>Date Booked</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= $room['id'] ?></td>
                    <td><?= $room['name'] ?></td>
                    <td><?= $room['block'] ?></td>
                    <td><?= $room['price'] ?></td>
                    <td><?= $room['beds'] ?></td>
                    <td><?= $room['dates'] ?></td>
                    <td><a href="pending.php?id=<?php echo $room['id'];?> "><button class="btn btn-primary">Book Now</button></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
