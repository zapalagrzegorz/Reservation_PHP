<?php
$firstName  = $lastName = $email = $telephone = $roomStartDateRaw = $roomStartDate = $roomEndsDate = $roomEndsDateRaw = "";
$firstNameErr = $lastNameErr = $emailErr = $telephoneErr = $quantityDoubleRoomErr= "";
$extraBedDoubleRoom = $doubleRoom = $isReserved = false;
$customerId = $roomNumber = $numReservedRooms = 0;
$tabRoomId = array();
$tabRoomExtraBed = array();
$tempNumber = 12;
$tommorow=strtotime("tomorrow");
$user = 'root';
$pass = $sql = $dbConnection= '';
$adres = '127.0.0.1';
$db = 'hotelmazury'; // $db = 'hotelTestDb'; 

require_once ('baza.inc');
$testDB = new baza_sql();
// jeśli nie ma, załóż nową db
if (!$testDB->Czy_jest($adres, $user, $pass, $db, 'pokoje')){
    require_once('newDB.php');
    header("Location: rezerwacja.php");
}

$dbConnection = new mysqli($adres, $user, $pass, $db) or die('Nie połączono z bazą danych');

$sql = "SET NAMES 'UTF8';";
if ($dbConnection->query($sql) === FALSE) {
    echo 'Error SET NAMES UTF8 ' . $dbConnection->error;
}
validateDate();



// ---------------------------
function validateDate() {

    global $roomStartDateRaw, $roomStartDate, $roomEndsDateRaw, $roomEndsDate;
    if( !empty($_POST['roomStartDate']) ) {
        $roomStartDateRaw = htmlentities($_POST['roomStartDate']);
        $roomStartDate = date('Y-m-d', strtotime($roomStartDateRaw));
    }
    if( !empty($_POST['roomEndsDate']) ) {
        $roomEndsDateRaw = htmlentities($_POST['roomEndsDate']);
        $roomEndsDate = date('Y-m-d', strtotime($roomEndsDateRaw));
    }
}
?>