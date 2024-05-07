<?php
include_once 'util.php';

class Menu {
    protected $text;
    protected $sessionId;

    function __construct($text, $sessionId) {
        $this->text = $text;
        $this->sessionId;
    }

    public function mainMenuRegistered() {
        $response =  "Welcome Hostel Reservation System, Reply with: \n";
        $response .= "1. View Rooms\n"; // Updated option
        $response .= "2. Book Rooms\n";
        $response .= "3. Mantaince request\n";
        $response .= "4. update requested mantainence\n";
        $response .= "5. delete requested mantainence\n";
        return "CON " . $response;
    }

    public function mainMenuUnregistered() {
        $response = "Welcome Hostel Reservation System, Reply with:  \n";
        $response .= "1. Register\n";
        return $response;
    }

    public function menuRegister($textArray) {
        // Registration logic
    }

    public function menuViewRooms($textArray) {
        // In this function, you directly handle the logic to fetch available rooms from the database
        // Assuming you have access to PDO object and your database connection is established properly

        $host = "localhost";
        $dbname = "project";
        $username = "root";
        $password = "";

      
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Query to retrieve available rooms
            $stmt = $pdo->query("SELECT * FROM rooms r WHERE NOT EXISTS (SELECT 1 FROM pending_rooms p WHERE p.room_id = r.id AND p.action IN ('Pending', 'Approved'))");
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Construct plain text response
            $response = "Available Rooms:\n";
            foreach ($rooms as $room) {
                $response .= "Room Id: " . $room['id'] . "\n";
                $response .= "Room Name: " . $room['name'] . "\n";
                $response .= "Block Number: " . $room['block'] . "\n";
                $response .= "Price per Month: " . $room['price'] . "\n\n";
            }
            // $response .= "Reply with the room ID to book a room.\n";
            // $response .= "Reply with '0' to go back.\n";
    
            return "CON " . $response; // Prefix 'CON' indicates continuation of the USSD session
        } catch (PDOException $e) {
            return "END Error: " . $e->getMessage(); // Prefix 'END' indicates the end of the USSD session
        }
    }

    public function menuBookromm($textArray) {
        session_start();
        // Include your database connection configuration here
        $host = "localhost";
        $dbname = "project";
        $username = "root";
        $password = "";
    
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Query to retrieve available rooms
            $stmt = $pdo->query("SELECT * FROM rooms r WHERE NOT EXISTS (SELECT 1 FROM pending_rooms p WHERE p.room_id = r.id AND p.action IN ('Pending', 'Approved'))");
            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Construct plain text response
            $response = "Available Rooms:\n";
            foreach ($rooms as $room) {
                $response .= "Room Id: " . $room['id'] . "\n";
                $rooId = $room['id'];
            }
    
            // Set the room ID in session
            $_SESSION['room_id'] = $rooId;
    
            // Check if user is logged in
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
            } else {
                $userId = null; // Set to null if user is not logged in
            }
    
            $pdo->beginTransaction();
    
            // Fetch room details from the rooms table
            $fetchRoomSQL = "SELECT name, block, price FROM rooms WHERE id = :roomId FOR UPDATE";
            $fetchRoomStmt = $pdo->prepare($fetchRoomSQL);
            $fetchRoomStmt->bindParam(':roomId', $rooId);
            $fetchRoomStmt->execute();
            $room = $fetchRoomStmt->fetch(PDO::FETCH_ASSOC);
    
            if ($room) {
                // Insert the room into the pending_rooms table with additional information
                $insertPendingSQL = "INSERT INTO pending_rooms (room_id, booked_date, action, user_id) VALUES (:roomId, CURRENT_TIMESTAMP, 'Pending', :userId)";
                $insertPendingStmt = $pdo->prepare($insertPendingSQL);
                $insertPendingStmt->bindParam(':roomId', $rooId);
                $insertPendingStmt->bindParam(':userId', $userId);
                $insertPendingStmt->execute();
    
                // Commit the transaction
                $pdo->commit();
    
                echo "Booking request sent. Waiting for admin approval.";
                // header("refresh:2;url=rooms.php");
            } else {
                echo "Invalid room selection.";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function manumantaintance($textArray) {
        $level = count($textArray);
    
        // USSD logic to collect information
        if ($level == 1) {
            echo "CON Enter your room name:\n";
        } else if ($level == 2) {
            echo "CON Enter your block name:\n";
        } else if ($level == 3) {
            echo "CON Enter your name:\n";
        } else if ($level == 4) {
            echo "CON Describe your issue:\n";
        } else if ($level == 5) {
            echo "CON Enter your phone number:\n";
        } else if ($level == 6) {
            echo "CON Enter today's date (YYYY-MM-DD):\n";
        } else if ($level == 7) {
            // Database connection configuration
            $host = "localhost";
            $dbname = "project";
            $username = "root";
            $password = "";
    
            try {
                // Establish a database connection
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // Retrieve input data from USSD array
                $rname = $textArray[1];
                $bname = $textArray[2];
                $name = $textArray[3];
                $desc = $textArray[4];
                $telephone = $textArray[5];
                $date = $textArray[6];
    
                // Construct and execute SQL query to insert data into maintenance table
                $sql = "INSERT INTO mantainance (rname, bname, username, description, telephone, date) 
                        VALUES (:rname, :bname, :name, :desc, :telephone, :date)";
                $stmt = $pdo->prepare($sql);
    
                // Bind parameters
                $stmt->bindParam(':rname', $rname);
                $stmt->bindParam(':bname', $bname);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':desc', $desc);
                $stmt->bindParam(':telephone', $telephone);
                $stmt->bindParam(':date', $date);
    
                // Execute the query
                $stmt->execute();
    
                echo "Record inserted successfully. Loading...";
                // You may want to redirect or display another message here
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
    public function menuUpdate($textArray) {
        $level = count($textArray);
    
        // USSD logic to collect information
        if ($level == 1) {
            echo "CON Enter ID of the issue to be updated:\n";
        } elseif ($level == 2) {
            // Database connection configuration
            $host = "localhost";
            $dbname = "project";
            $username = "root";
            $password = "";
    
            try {
                // Establish a database connection
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // Retrieve the ID of the issue to be updated
                $id = $textArray[1];
    
                // Check if the entered ID exists in the maintenance table
                $checkIssueSQL = "SELECT * FROM mantainance WHERE mid = :id";
                $checkIssueStmt = $pdo->prepare($checkIssueSQL);
                $checkIssueStmt->bindParam(':id', $id);
                $checkIssueStmt->execute();
                $issueExists = $checkIssueStmt->fetch(PDO::FETCH_ASSOC);
    
                if ($issueExists) {
                    // If the issue exists, prompt the user to choose the field to update
                    echo "CON Choose the field to update:\n";
                    echo "1. Room Name\n";
                    echo "2. Block Name\n";
                    echo "3. Username\n";
                    echo "4. Description\n";
                    echo "5. Telephone\n";
                    echo "6. Date\n";
                } else {
                    echo "Issue with ID $id does not exist.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } elseif ($level == 3) {
            // Get the selected field to update
            $selectedField = $textArray[2];
    
            // Set appropriate prompt based on the selected field
            $prompt = "";
            switch ($selectedField) {
                case '1':
                    $prompt = "Enter new Room Name:\n";
                    break;
                case '2':
                    $prompt = "Enter new Block Name:\n";
                    break;
                case '3':
                    $prompt = "Enter new Username:\n";
                    break;
                case '4':
                    $prompt = "Enter new Description:\n";
                    break;
                case '5':
                    $prompt = "Enter new Telephone:\n";
                    break;
                case '6':
                    $prompt = "Enter new Date (YYYY-MM-DD):\n";
                    break;
                default:
                    echo "Invalid selection.";
                    exit;
            }
            echo "CON $prompt\n";
        } elseif ($level == 4) {
            // Database connection configuration
            $host = "localhost";
            $dbname = "project";
            $username = "root";
            $password = "";
    
            try {
                // Establish a database connection
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                // Retrieve the ID of the issue and the new value from the USSD input
                $id = $textArray[1];
                $newValue = $textArray[3];
    
                // Get the field to update based on the selected option
                $selectedField = $textArray[2];
                switch ($selectedField) {
                    case '1':
                        $fieldToUpdate = "rname";
                        break;
                    case '2':
                        $fieldToUpdate = "bname";
                        break;
                    case '3':
                        $fieldToUpdate = "username";
                        break;
                    case '4':
                        $fieldToUpdate = "description";
                        break;
                    case '5':
                        $fieldToUpdate = "telephone";
                        break;
                    case '6':
                        $fieldToUpdate = "date";
                        break;
                    default:
                        echo "Invalid selection.";
                        exit;
                }
    
                // Update the selected field in the maintenance table
                $updateMaintenanceSQL = "UPDATE mantainance SET $fieldToUpdate = :newValue WHERE mid = :id";
                $updateMaintenanceStmt = $pdo->prepare($updateMaintenanceSQL);
                $updateMaintenanceStmt->bindParam(':newValue', $newValue);
                $updateMaintenanceStmt->bindParam(':id', $id);
                $updateMaintenanceStmt->execute();
    
                echo "Maintenance record updated successfully.";
                // You may want to redirect or display another message here
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
    public function menuDelete($textArray) {
        // Database connection configuration
        $host = "localhost";
        $dbname = "project";
        $username = "root";
        $password = "";
    
        try {
            // Establish a database connection
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // USSD logic to collect information
            $level = count($textArray);
            if ($level == 1) {
                echo "CON Enter ID of the record to be deleted:\n";
            } elseif ($level == 2) {
                $id = $textArray[1];
    
                // Check if the entered ID exists in the database
                $checkRecordSQL = "SELECT * FROM mantainance WHERE mid = :id";
                $checkRecordStmt = $pdo->prepare($checkRecordSQL);
                $checkRecordStmt->bindParam(':id', $id);
                $checkRecordStmt->execute();
                $recordExists = $checkRecordStmt->fetch(PDO::FETCH_ASSOC);
    
                if ($recordExists) {
                    // If the record exists, prompt the user for confirmation
                    echo "CON Are you sure you want to delete this record? (Y/N)\n";
                } else {
                    // If the record doesn't exist, inform the user
                    echo "The specified ID does not exist in the database.\n";
                }
            } elseif ($level == 3) {
                $confirmation = strtoupper($textArray[2]);
    
                if ($confirmation == 'Y') {
                    // User confirmed deletion, proceed with deleting the record
                    $id = $textArray[1];
    
                    // Construct and execute SQL query to delete the record
                    $deleteRecordSQL = "DELETE FROM mantainance WHERE mid = :id";
                    $deleteRecordStmt = $pdo->prepare($deleteRecordSQL);
                    $deleteRecordStmt->bindParam(':id', $id);
                    $deleteRecordStmt->execute();
    
                    echo "Record with ID $id has been successfully deleted.\n";
                } else {
                    // User opted not to delete the record
                    echo "Deletion operation canceled.\n";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    
    public function middleware($text) {
        // Remove entries for going back and going to the main menu
        $text = $this->goBack($text);
        $text = $this->goToMainMenu($text);
        return $text; // Ensure to return the modified USSD response
    }

    public function goBack($text) {
        //1*4*5*1*4*98*5*1234*98
        $explodedText = explode("*",$text);
        while(array_search(Util::$GO_BACK, $explodedText) !== false){
            $firstIndex = array_search(Util::$GO_BACK, $explodedText);
            array_splice($explodedText, $firstIndex-1, 2);
        }
        return join("*", $explodedText);
    }

    public function goToMainMenu($text) {
        //1*4*5*1*4*99*5*1234*99
        $explodedText = explode("*",$text);
        while(array_search(Util::$GO_TO_MAIN_MENU, $explodedText) !== false){
            $firstIndex = array_search(Util::$GO_TO_MAIN_MENU, $explodedText);
            $explodedText = array_slice($explodedText, $firstIndex + 1);
        }
        return join("*",$explodedText);
    }
    public function checkUserExistsByNumber($phoneNumber) {
        // Database connection configuration
        $host = "localhost";
        $dbname = "project";
        $username = "root";
        $password = "";

        try {
            // Establish a database connection
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query to check if user exists by phone number
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE number = ?");
            $stmt->execute([$phoneNumber]);
            $count = $stmt->fetchColumn();

            return $count > 0; // Return true if count is greater than 0, indicating user exists
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Return false in case of error
        }
    }

    public function addUser($data) {
        // Database connection configuration
        $host = "localhost";
        $dbname = "project";
        $username = "root";
        $password = "";
    
      try {
        // Establish a database connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute SQL query to insert user data
        $stmt = $pdo->prepare("INSERT INTO users (name, email, number, sex, location, password) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Assign values from $data array to variables
        $name = $data['name'];
        $email = isset($data['email']) ? $data['email'] : ''; // Default to empty string if not provided
        $number = $data['number'];
        $sex = isset($data['sex']) ? $data['sex'] : ''; // Default to empty string if not provided
        $location = isset($data['location']) ? $data['location'] : ''; // Default to empty string if not provided
        $password = $data['password'];

        // Bind parameters and execute the query
        $stmt->execute([$name, $email, $number, $sex, $location, $password]);

        // Construct response message
        $message = "User added successfully.";

        return ['status' => true, 'message' => $message]; // Return success status and message
    } catch (PDOException $e) {
        // Handle any database connection errors
        $errorMessage = "Error: " . $e->getMessage();
        return ['status' => false, 'message' => $errorMessage]; // Return error status and message
    }
    }
    
}

?>
