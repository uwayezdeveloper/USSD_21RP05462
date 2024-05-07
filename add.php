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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send"])) {
    // Retrieve form data
    $roomName = $_POST["productName"];
    $blockNumber = $_POST["quantity"];
    $pricePerMonth = $_POST["price"];
    $numOfBeds = $_POST["beds"];
    $dateBooked = $_POST["date"];

    // Prepare SQL statement
    $sql = "INSERT INTO rooms (name, block, price,beds, dates) 
            VALUES (:roomName, :blockNumber, :pricePerMonth, :numOfBeds, :dateBooked)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':roomName', $roomName);
    $stmt->bindParam(':blockNumber', $blockNumber);
    $stmt->bindParam(':pricePerMonth', $pricePerMonth);
    $stmt->bindParam(':numOfBeds', $numOfBeds);
    $stmt->bindParam(':dateBooked', $dateBooked);

    // Execute the query
    try {
        $stmt->execute();
       
        echo "Record inserted successfully. loading....";
        header("refresh:2;url=admindash.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        header("refresh:2;url=add.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <title>Stock Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="row mt-0">
<div class="col-lg-4" >
<?php
include 'admindash.php';
?>
</div>

    
    <div class="container col-lg-8" >
        <h1>Room Recording</h1>
        <form method="POST" action="#">
            <div class="form-group">
                <label >Room name</label>
                <input type="text" class="form-control" name="productName" placeholder="Enter room name">
            </div>
            <div class="form-group">
            <!-- <label >select Groundnuts type</label> -->
            <!-- <select name="u">
                    <option value="Malawi">Malawi</option>
                    <option  value="Teal">Teal</option>
                    <option value="white">white</option>
                    <option  value="Red">Red</option>
                    </select><br> -->
                <label>Block number</label>
               
                <input type="text" class="form-control" name="quantity" placeholder="Enter block number">
               
            </div>
            <div class="form-group">
                <label >Price per month</label>
                <input type="number" class="form-control" name="price" placeholder="Enter the price ">
            </div>
            <div class="form-group">
                <label >number of beds in room</label>
                <input type="number" class="form-control" name="beds">
            </div>
            <div class="form-group">
                <label >Date booked</label>
                <input type="date" class="form-control" name="date">
            </div>
            <input type="submit" name="send" class="btn btn-primary" value="add to rooms">
        </form>
    </div>
</div>
    
    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
