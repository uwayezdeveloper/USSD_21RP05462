<?php
include_once 'menu.php';

// Receive data from the gateway 
$number = $_POST['from'];
$text = $_POST['text']; 
$textArray = explode(" ", $text);

// Define $sessionId or pass it as an argument when creating the Menu object
$sessionId = ""; // Define or obtain the session ID as needed

if(count($textArray) >= 5){
    $name = $textArray[0];
    $email = $textArray[1];
    $sex = $textArray[2];
    $location = $textArray[3];
    $password = $textArray[4];

    if($name == ''){
        echo "END Fill your name";
    } else if($email == ''){
        echo "END Fill your email";
    } else if($sex == ''){
        echo "END Fill your sex";
    } else if($location == ''){
        echo "END Fill your location";
    } else if($password == ''){
        echo "END Fill your password";
    } else {
        $menu = new Menu($textArray, $sessionId); // Pass $sessionId as an argument if needed
        $isRegistered = $menu->checkUserExistsByNumber($number);
        if($isRegistered){
            echo "END Already registered";
        } else {
            $data = [
                'name' => $name,
                'email' => $email,
                'number' => $number,
                'sex' => $sex,
                'location' => $location,
                'password' => $password
            ];
            $insert = $menu->addUser($data);
            echo $insert['message'] . $name;
        }
    }
} else {
    echo "END Your SMS must contain all required information."; // Inform the user if not enough information provided
}
?>
