<?php

// wyświetlanie wyników dostępnych pokoi
if ($_SERVER["REQUEST_METHOD"] == "POST" && !(isset($_POST['updateDB'])) ) {
    if($roomStartDate !== "" && $roomEndsDate !== "") {
        $sql = "SELECT * FROM pokoje WHERE pokoje.IdPokoju NOT IN (
            SELECT rezerwacje.IDPokoju
            FROM rezerwacje JOIN pokoje on rezerwacje.IDPokoju = pokoje.IdPokoju
            WHERE rezerwacje.DataPoczatkowa  >= '$roomStartDate' AND rezerwacje.DataKoncowa <= '$roomEndsDate'
        );";
        // $dbConnection = new mysqli($adres, $user, $pass, $db) or die('Nie połączono z bazą danych');
        $result = $dbConnection->query($sql);
        if ($result->num_rows > 0) {
            echo '<a href="#" class="centerText list-group-item list-group-item-success">Pokoje dostępne w okresie między: ' .  $roomStartDate . ' a ' . $roomEndsDate . '</a>';
            while($row = $result->fetch_assoc()) {
            
                $loopResult = '
                    <a href="#" class="centerText list-group-item list-group-item-action list-group-item-info"> 
                        <input type="checkbox" name=roomResult'.$roomNumber.'> Numer pokoju '
                        .$row['IdPokoju']. ', cena ' .  $row["Cena"] . 'zł/doba, pokój dla osób: ' . $row["RodzajPokoju"] .'
                        <input class="hidden" type="number" name="roomId'.$roomNumber.'" value='.$row["IdPokoju"]. '>
                        <input type="checkbox" name="isExtraBed'.$roomNumber.'">Dodatkowe łóżko?
                    </a>
                ';
                echo $loopResult;
                $roomNumber++;
            }
            // formularz rezerwacyjny
        echo '<fieldset>
                <legend class="centerText" style="padding-top: 20px">Rezerwacja</legend>
                <div class="centerText">
                    <label class="formName" for="firstName">Imię:</label>
                    <input type="text" name="firstName" value="'; echo $firstName; echo '" id="firstName" class="form-control" >
                    <span class="error">*'; echo $firstNameErr; echo'</span>
                    <span>Nazwisko</span>
                    <input type="text" name="lastName" value="'; echo $lastName; echo '" class="form-control" >
                    <span class="error">*'; echo $lastNameErr; echo '</span>
                </div>
                <div class="centerText">
                    <span>Telefon</span>
                    <input type="text" name="telephone" value="'; echo $telephone; echo '" class="form-control">
                    <span class="error">*'; echo $telephoneErr; echo '</span>
                    <span>E-mail</span> 
                    <input id="emailInput" type="text" name="email" value="'; echo $email; echo '" class="form-control">
                    <span class="error">*'; echo $emailErr; echo '</span>
                </div>
                <div class="hidden">
                    <input type="date" name="roomStartDate" value="'; echo $roomStartDate; echo '">
                    <input type="date" name="roomEndsDate" value="'; echo $roomEndsDate; echo '">
                </div>
                <div class="wrap">
                    <input class="hidden" type="checkbox" name="updateDB" id="updateDBCheckbox">
                    <input class="btn btn-success" type="submit" formnovalidate id="js-updateDBButton" value="Rezerwuj">
                </div>
            </fieldset>
        </form>';
        }
        else {
            echo '<div class="centerText list-group-item list-group-item-action list-group-item-warning" style="font-weight: 500">Niestety, ale brak wolnych pokoi w tym okresie. Proszę wybierz inny przedział czasowy</div>';
        }
    }
    else {
        echo 'brak daty';
    }
    // $dbConnection->close();
    // unset($dbConnection);
    // checkbox jest jako switch niezbedny do odroznienia czy wysyłane dane maja być przetwarzane jako rezerwacja -->
    // wyświetl formularz rezerwacyjny gdy wynik jest pozytywny
}
?>