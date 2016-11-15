<?php
$firstName  = $lastName = $email = $telephone = $roomStartDateRaw = $roomStartDate = $roomEndsDate = $roomEndsDateRaw = "";
$firstNameErr = $lastNameErr = $emailErr = $telephoneErr = $quantityDoubleRoomErr= "";
$extraBedDoubleRoom = $doubleRoom = false;
$customerId = $roomNumber = $numReservedRooms = 0;
$tabRoomId = array();
$tempNumber = 12;
$isErrors = false;
$tommorow=strtotime("tomorrow");
$user = 'root';
$pass = '';
$sql = $dbConnection= "";

$db = 'hotelMazury'; // $db = 'hotelTestDb'; 
$adres = 'localhost';
// require 'dbVariables.php';


require ('baza.inc');
$testDB = new baza_sql();
if (!$testDB->Czy_jest($adres, $user, $pass, $db, "pokoje")){
    echo "zakładam nową bazę";
    require('newDB.php');
    header("Location: rezerwacja.php");
}

$dbConnection = new mysqli('localhost', $user, $pass, $db) or die("Nie połączono z bazą danych");

$sql = "SET NAMES 'UTF8';";
if ($dbConnection->query($sql) === FALSE) {
    echo 'Error SET NAMES UTF8 ' . $dbConnection->error;
}
// walidacja czasu - obsługa daty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    validateDate();
}   
//-----------------------------------------------------------------------------//
// OBSŁUGA UPDATE'OWANIA WYNIKÓW
    
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateDB'])) { 
    // validacja danych klienta
    // imie
    
    if (empty($_POST["firstName"])) {
        $firstNameErr = "Imię jest wymagane";
        $isErrors = true;
    } else {
        $firstName = test_input($_POST["firstName"]);
    }
    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/",$firstName)) {
      $firstNameErr = "Proszę używać tylko liter";
      $isErrors = true;
    }
    // nazwisko
    if(empty($_POST["lastName"])){
        $lastNameErr = "Nazwisko jest wymagane";
        $isErrors = true;
    } else {
        $lastName = test_input($_POST["lastName"]);
    }
    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/",$lastName)) {
        $lastNameErr = "Proszę używać tylko liter";
        $isErrors = true;
    }
    // telefon
    if(empty($_POST["telephone"])){
        $telephoneErr = "Telefon jest wymagany";
        $isErrors = true;
    } else {
        $telephone = test_input($_POST["telephone"]);
    }
    if (!preg_match("/^\d{9}$/",$telephone)) {
        $telephoneErr = "Nieprawidłowy format telefonu [123456789]";
        $isErrors = true; 
    }
    // email
    if(empty($_POST["email"])){
        $emailErr = "E-mail jest wymagany";
        $isErrors = true;
    } else {
        $email = test_input($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Nieprawidłowy format e-mail";
        $isErrors = true; 
    }
    if($isErrors){
        exit;
    }

// sprawdz czy klient jest w bazie, 
// jeśli tak, pobierz jego ID, inaczej dodaj go do Bazy 
    if(!getCustomerID()){
        setCustomerID();
    }

// ustal IdPokojów wybranych przez klienta
    getIDRoomsToReserve();

// update DB
    setSQLReservedRooms($tabRoomId, $customerId, $roomStartDate, $roomEndsDate);

}
function test_input($data) {
        
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// sanitazacja daty
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

function getCustomerID() {
    global $lastName, $firstName, $email, $telephone, $dbConnection, $customerId;
    $sql = "SELECT * FROM klienci WHERE Nazwisko = '$lastName' AND Imie = '$firstName'
                 AND email='$email' AND telephone = '$telephone'";
    if($result = $dbConnection->query($sql)){
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $customerId = $row["IDKlienta"];
            return true;
        } else {
            return false;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $dbConnection->error;
        return false;
    }
}

function setCustomerID() {
    global $firstName, $lastName, $email, $telephone, $dbConnection, $customerId;
    $sql = "INSERT INTO klienci (Imie, Nazwisko, email, telephone)
            VALUES ('$firstName', '$lastName', '$email', $telephone)";
    if ($dbConnection->query($sql) === TRUE) {
        $customerId = $dbConnection->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $dbConnection->error;
    }
}
function getIDRoomsToReserve(){
    global $tabRoomId, $tempNumber, $numReservedRooms;
    for($i = 0; $i < $tempNumber; $i++){  
        // czy dla dany pokój był dostępny do rezerwacji
        if(!empty($_POST['roomResult'.$i])){
            // czy został zarezerwowany? - zaznaczony checkbox rezerwacyjny dla danego pokoju
            if(isset($_POST['roomResult'.$i])) {
            // jeśli tak, to pobierz ID pokoju; roomId jest kluczem (name) dla wartości ID (value)
                $tabRoomId[$numReservedRooms] = $_POST['roomId'.$i];
                $numReservedRooms++;
            }
        }
    }
}
/**
 * setSQLReservedRooms
 *
 * Sets sql string to reserve selected rooms
 *
 * @$IDcustom (int) customer ID
 * @$roomIDs (array) room or rooms ID 
 */
function setSQLReservedRooms($roomIDs, $IDcustom, $startDate, $endDate) {
    global $sql, $numReservedRooms, $dbConnection;
    if($numReservedRooms === 1){
        $sql = "INSERT INTO rezerwacje (IdPokoju, IDKlienta, DataPoczatkowa, DataKoncowa)
                VALUES ($roomIDs[0], $IDcustom, '$startDate', '$endDate');";
        if($dbConnection->query($sql) === FALSE){
            echo "Error: " . $sql . "<br>" . $dbConnection->error;
        }
    } else {
        for($i = 1; $i < $numReservedRooms; $i++){
            $sql .= "INSERT INTO rezerwacje (IdPokoju, IDKlienta, DataPoczatkowa, DataKoncowa )
            VALUES ( $roomIDs[$i], $IDcustom, '$startDate', '$endDate');";
        }
        if ($dbConnection->multi_query($sql) === TRUE) {
            echo '<h2 style="padding-top: 20px;" class="centerText">Skutecznie dokonano rezerwacji</h2>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbConnection->error;
        }
    }
}
?>