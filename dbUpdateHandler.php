<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateDB'])) { 

// ustal czy Klient wybrał pokój/pokoje i ich ID
    getIDRoomsToReserve();

// validacja danych klienta
    if(isInputError()){
        echo '<p class="finalMessage errorSlight centerText">Popraw dane w formularzu</p>';
    }
    else {
// sprawdz czy klient jest w bazie, 
// jeśli tak, pobierz jego ID, inaczej dodaj go do Bazy 
        if(!getCustomerID()){
            setCustomerID();
        }
// update DB
        setSQLReservedRooms($tabRoomId, $customerId, $roomStartDate, $roomEndsDate, $tabRoomExtraBed);
    }
}
//-----------------------------------------------------------------------------//
// FUNKCJE POMOCNICZE

function isInputError() {

    global $firstName, $firstNameErr, $lastName, $lastNameErr, $telephone, $telephoneErr, $email, $emailErr, $numReservedRooms, $roomStartDate, $roomEndsDate;
    $today=strtotime("today");
    
    $isInputNotValid = FALSE;
    

    // liczba pokoi
    if($numReservedRooms === 0){
        $isInputNotValid = true;
        echo '<h2 class="finalMessage centerText">Wybierz choć jeden pokój do rezerwacji</h2>';
    }
    
    // liczba pokoi
    if( strtotime($roomStartDate) >= strtotime($roomEndsDate)){
        $isInputNotValid = true;
        echo '<h2 class="finalMessage centerText">Sprawdź daty rezerwacji</h2>';
    }

    // imie
    if (empty($_POST["firstName"])) {
        $firstNameErr = "Imię jest wymagane";
        $isInputNotValid = true;
    } else {
        $firstName = test_input($_POST["firstName"]);
    }
    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/",$firstName)) {
      $firstNameErr = "Proszę używać tylko liter";
      $isInputNotValid = true;
    }

// nazwisko
    if(empty($_POST["lastName"])){
        $lastNameErr = "Nazwisko jest wymagane";
        $isInputNotValid = true;
    } else {
        $lastName = test_input($_POST["lastName"]);
    }
    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/",$lastName)) {
        $lastNameErr = "Proszę używać tylko liter";
        $isInputNotValid = true;
    }

// telefon
    if(empty($_POST["telephone"])){
        $telephoneErr = "Telefon jest wymagany";
        $isInputNotValid = true;
    } else {
        $telephone = test_input($_POST["telephone"]);
    }
    if (!preg_match("/^\d{9}$/",$telephone)) {
        $telephoneErr = "Nieprawidłowy format telefonu [123456789]";
        $isInputNotValid = true; 
    }

// email
    if(empty($_POST["email"])){
        $emailErr = "E-mail jest wymagany";
        $isInputNotValid = true;
    } else {
        $email = test_input($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Nieprawidłowy format e-mail";
        $isInputNotValid = true; 
    }
    return $isInputNotValid;
}

function test_input($data) {
        
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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

    global $tabRoomId, $tempNumber, $numReservedRooms, $tabRoomExtraBed;
    for($i = 0; $i < $tempNumber; $i++){  
        // REFACTOR Sprawdzic tylko jedna walidacje
        // czy dla dany pokój był dostępny do rezerwacji
        if(!empty($_POST['roomResult'.$i])){
            // czy został zarezerwowany? - zaznaczony checkbox rezerwacyjny dla danego pokoju
            if(isset($_POST['roomResult'.$i])) {
            // jeśli tak, to pobierz ID pokoju; roomId jest kluczem (name) dla wartości ID (value)
                $tabRoomId[$numReservedRooms] = $_POST['roomId'.$i];
                $tabRoomExtraBed[$numReservedRooms] = (isset($_POST['isExtraBed'.$i])) ? true : false;
                $numReservedRooms++;
            }
        }
    }
}
/**
 * setSQLReservedRooms
 *
 * Sets and execute sql to reserve selected rooms
 *
 * @$IDcustom (int) customer ID
 * @$roomIDs (array) room or rooms ID 
 */
function setSQLReservedRooms($roomIDs, $IDcustom, $startDate, $endDate, $tabRoomExtraBed) {
    global $numReservedRooms, $dbConnection, $isReserved;
    $sql = "INSERT INTO rezerwacje (IdPokoju, IDKlienta, DataPoczatkowa, DataKoncowa, extraBed)
                VALUES ($roomIDs[0], $IDcustom, '$startDate', '$endDate', '$tabRoomExtraBed[0]');";
    if($numReservedRooms === 1){
        if($dbConnection->query($sql) === TRUE){
           echo '<h2 class="finalMessage centerText">Skutecznie dokonano pojedyńczej rezerwacji</h2>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbConnection->error;
        }
    } else {
        for($i = 1; $i < $numReservedRooms; $i++){
            $sql .= "INSERT INTO rezerwacje (IdPokoju, IDKlienta, DataPoczatkowa, DataKoncowa, extraBed)
            VALUES ($roomIDs[$i], $IDcustom, '$startDate', '$endDate', $tabRoomExtraBed[$i]);";
        }
        if ($dbConnection->multi_query($sql) === TRUE) {
           echo '<h2 class="finalMessage centerText">Skutecznie dokonano wielokrotnej rezerwacji</h2>';
        } else {
            echo "Error: " . $sql . "<br>" . $dbConnection->error;
        }
    }
    $dbConnection->close();
}
?>