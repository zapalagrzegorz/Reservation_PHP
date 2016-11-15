<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateDB'])){ 
    echo "DbHandlerUpdateFile - roomNumber = ".$roomNumber;
    // validacja
    if (empty($_POST["firstName"])) {
        $firstNameErr = "Imię jest wymagane";
    } else {
        $firstName = test_input($_POST["firstName"]);
    }
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/",$firstName)) {
      $firstNameErr = "Proszę używać tylko liter"; 
    }

    if(empty($_POST["lastName"])){
        $lastNameErr = "Nazwisko jest wymagane";
    } else {
        $lastName = test_input($_POST["lastName"]);
    }
    if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]*$/",$lastName)) {
        $lastNameErr = "Proszę używać tylko liter"; 
    }

    if(empty($_POST["telephone"])){
        $telephoneErr = "Telefon jest wymagany";
    } else {
        $telephone = test_input($_POST["telephone"]);
    }
    if (!preg_match("/^\d{9}$/",$telephone)) {
        $telephoneErr = "Nieprawidłowy format telefonu [123456789]"; 
    }

    if(empty($_POST["email"])){
        $emailErr = "E-mail jest wymagany";
    } else {
        $email = test_input($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Nieprawidłowy format e-mail"; 
    }

    if(isset($_POST['doubleRoom'])){        
        if(($_POST["quantityDoubleRoom"] > 0)){
            $quantityDoubleRoom = $_POST["quantityDoubleRoom"];
        }
        if (!filter_var($quantityDoubleRoom, FILTER_VALIDATE_INT)) {
            $quantityDoubleRoomErr = "Nieprawidłowy dane liczbowe";
        }
    }

    $customerId = 0;

// sprawdz czy klient jest w bazie, jeśli tak, pobierz jego ID, 
// funkcja
    $sql = "SELECT * FROM klienci WHERE Nazwisko = '$lastName' AND Imie = '$firstName'
                 AND email='$email' AND telephone = '$telephone'";  
    // IdKlienta = 5";
    
    if($result = $db->query($sql)){
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $customerId = $row["IDKlienta"];
            echo "Klient istnieje w bazie o nr id: ".$customerId;
        }
    }
//jeżeli nie ma w bazie - <dodaj></dodaj>
    if($customerId === 0 && !empty($firstName)){
        $langadb = "SET NAMES utf8";
        mysqli_query($db, $langadb);
        $sql = "INSERT INTO klienci (Imie, Nazwisko, email, telephone)
                VALUES ('$firstName', '$lastName', '$email', $telephone)";
        if ($db->query($sql) === TRUE) {
            // $last_id = $db->insert_id;
            echo '<h1> dodano klienta do bazy o id '.$db->insert_id.' </h1>';
            // sprawdz wpisana osobe jak sie wyswietla
            // $IdNowejOsoby = $db->insert_id;
            // $sql = "SELECT * FROM klienci WHERE idKlienta='$IdNowejOsoby'";
            // if($result2 = $db->query($sql)){
            //     if($result2->num_rows > 0){
            //         $row = $result->fetch_assoc();
            //         echo '<h1>Wpisano właśnie osobę o nazwisku '.$row["Nazwisko"].'</h1>';
            //     }
            // }
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    }
// ustal numer wybrany przez klienta
    // przebiegnij po wszystkich wynikach
    // sprawdz checkbox 
    // jesli jest zaznaczony pobierz id pokoju - do tablicy
    $tabRoomId = array();
    echo "liczba dostepnych pokoi:".$roomNumber;
    $numReservedRooms = 0;
    for($i = 0; $i < $roomNumber;$i++){  
        echo "Sprawdzam zmienną POST o nazwie: ".$_POST['roomResult'.$roomNumber];
        if(isset($_POST['roomResult'.$roomNumber])) {
            echo "istieje zaznaczony checkbox o nr: ".$_POST['roomResult'.$roomNumber];
            $tabRoomId[$numReservedRooms++] = $_POST['roomId'.$roomNumber];
        }
    }
    echo "<br>Po pętli TabRoomID".$tabRoomId[0];
    for($x = 0; $x < $numReservedRooms; $x++) {
        echo $tabRoomId[$x];
        echo "<br>";
    }
            
        // DOPISZ REZERWACJĘ
            // Idklienta z pkt poprzedniego
            // $sql = "INSERT INTO rezerwacje (IDPokoju, IDKlienta, DataPoczatkowa, DataKoncowa) 
            // --         VALUES (1, 2, '$doubleRoomStartDate', '$doubleRoomEndsDate')";
            // if ($db->query($sql) === TRUE) {
            //     echo "<h1> Dokonano rezerwacji</h1>";
            // } else {
            //     echo "Error: " . $sql . "<br>" . $db->error;
            // }
            // $db->close();

            // $sql = "INSERT INTO MyGuests (firstname, lastname, email)
                // VALUES ('John', 'Doe', 'john@example.com');";
                // $sql .= "INSERT INTO MyGuests (firstname, lastname, email)
                // VALUES ('Mary', 'Moe', 'mary@example.com');";
                // $sql .= "INSERT INTO MyGuests (firstname, lastname, email)
                // VALUES ('Julie', 'Dooley', 'julie@example.com')";

                // if ($conn->multi_query($sql) === TRUE) {
                //     echo "New records created successfully";
                // } else {
                //     echo "Error: " . $sql . "<br>" . $conn->error;
                // }
}

function test_input($data) {
	
	$data = trim($data);
	
	$data = stripslashes($data);
	
	$data = htmlspecialchars($data);
	
	return $data;
}

?>