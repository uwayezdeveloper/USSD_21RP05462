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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (isset($_POST["login"])) {
        if ($_POST["login"] == "Unlock") {
            // Retrieve user data


            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password using MD5
                if ($password === $user['password']) {
                    // Start session and store user information
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];

                    // Redirect to user dashboard
                    header("Location: user/userdash.php");
                    exit();
                } 
                else {
                    echo "Invalid password loading....";
                    header("refresh:2;url=home.php");
                }
            } else {
                echo "user not found loading....";
                header("refresh:2;url=home.php");
            }
        } 
        
        elseif ($_POST["login"] == "Unlock As Admin") {
            $sql = "SELECT * FROM adminn WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Verify password using MD5
                if ($password === $user['password']) {
                    // Start session and store user information
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];

                    // Redirect to user dashboard
                    // header("Location: admindash.php");
                    echo "loading....";
                    header("refresh:2;url=admindash.php");
                    exit();
                } 
                else {
                    echo "Invalid password loading....";
                    header("refresh:2;url=home.php");
                }
            } else {
                echo "user not found loading....";
                header("refresh:2;url=home.php");
            }
            exit;
        }
    }
}

// If no redirection occurred, and you want to display something on process2.php,
// make sure to do it after the PHP block
?>
<!-- Your HTML content for process2.php goes here -->
