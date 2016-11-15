<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rezerwacja</title>
        <link href="https://fonts.googleapis.com/css?family=Eczar:700|Lato:400,700|Source+Sans+Pro:600,700,900" rel="stylesheet">
        <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE"
            crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css\style.css">
        <link rel="stylesheet" type="text/css" href="css\rezerwacjaStyle.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    </head>
    <body>
<?php
require_once 'dbHandler.php'; 
?>
        <form class="searchForm form-inline" name="" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <fieldset>
                <legend class="centerText">Szukaj wolnych pokoi</legend>
                <div class="centerText">
                    <span>od</span>
                    <input class="form-control" type="date" name="roomStartDate" value="<?php echo date("Y-m-d");?>" >
                    <span>do</span>
                    <input class="form-control" type="date" name="roomEndsDate" value="<?php echo date("Y-m-d", $tommorow);?>">
                </div>
                <div class="wrap">
                    <!-- novalidate dla celów walidacji PHP -->
                    <input id="js-searchBtn" class="btn btn-primary" type="submit" formnovalidate value="Szukaj">
                </div>
            </fieldset>
        </form>
        <div class="container hidden" id="roomResults">
            <form>
                <div class="list-group">
     <!--wyświetlanie wyników-->
                </div>
            </form>
        </div>
        <form id="js-reservationForm" class="reservationForm form-inline" name="reservationForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<?php
// wyświetlanie wyników dostępnych pokoi
if ($_SERVER["REQUEST_METHOD"] == "POST" && !(isset($_POST['updateDB'])) ) {
    if($roomStartDate !== "" && $roomEndsDate !== "") {
        $sql = "SELECT * FROM pokoje WHERE pokoje.IdPokoju NOT IN (
            SELECT rezerwacje.IDPokoju
            FROM rezerwacje JOIN pokoje on rezerwacje.IDPokoju = pokoje.IdPokoju
            WHERE rezerwacje.DataPoczatkowa  >= '$roomStartDate' AND rezerwacje.DataKoncowa <= '$roomEndsDate'
        )";
        $result = $dbConnection->query($sql);
        if ($result->num_rows > 0) {
            echo '<a href="#" class="centerText list-group-item list-group-item-success">Pokoje dostępne w okresie między: ' .  $roomStartDate . ' a ' . $roomEndsDate . '</a>';
            while($row = $result->fetch_assoc()) {
                $loopResult = '
                    <a href="#" class="centerText list-group-item list-group-item-action list-group-item-info"> 
                        <input type="checkbox" name=roomResult'.$roomNumber.'> Numer pokoju '
                        .$row['IdPokoju']. ', cena ' .  $row["Cena"] . 'zł/doba, pokój dla osób: ' . $row["RodzajPokoju"] .'
                        <input class="hidden" type="number" name="roomId'.$roomNumber.'" value='.$row["IdPokoju"]. '>
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
                    <p>'; echo "The time is " . date("h:i:sa"); echo '</p>
                </div>
            </fieldset>
        </form>';
        }
        else {
            echo '<div class="centerText list-group-item list-group-item-action list-group-item-warning" style="font-weight: 500">Niestety, ale brak wolnych pokoi w tym okresie. Proszę wybierz inny przedział czasowy</div>';
        }
    }
    // checkbox jest jako switch niezbedny do odroznienia czy wysyłane dane maja być przetwarzane jako rezerwacja -->
    // wyświetl formularz rezerwacyjny gdy wynik jest pozytywny
    
}
?>
            
        <script src="js/script.js"></script>
    </body>
</html>