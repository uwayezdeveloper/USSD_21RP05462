<?php
include_once 'menu.php';

$sessionId = $_POST['sessionId'] ?? '';
$phoneNumber = $_POST['phoneNumber'] ?? '';
$serviceCode = $_POST['serviceCode'] ?? '';
$text = $_POST['text'] ?? '';

$isRegistered = true; // You need to determine if the user is registered

$menu = new Menu($text, $sessionId);
$text = $menu->middleware($text);

if ($text === "" && !$isRegistered) {
    echo $menu->mainMenuUnregistered();
} elseif ($text === "" && $isRegistered) {
    echo $menu->mainMenuRegistered();
} elseif (!$isRegistered) {
    $textArray = explode("*", $text);
    switch ($textArray[0]) {
        case 1:
            $menu->menuRegister($textArray);
            break;
        default:
            echo "END Invalid option, retry";
    }
} else {
    $textArray = explode("*", $text);
    switch ($textArray[0]) {
        case 1:
            // Call the menuViewRooms function instead of menuSendMoney
            echo $menu->menuViewRooms($textArray);
            break;
        case 2:
            $menu->menuBookromm($textArray);
            break;
        case 3:
            $menu->manumantaintance($textArray);
            break;
        case 4:
            $menu->menuUpdate($textArray);
            break;
        case 5:
            $menu->menuDelete($textArray);
            break;
        default:
            echo "END Invalid choice\n";
    }
}
?>
