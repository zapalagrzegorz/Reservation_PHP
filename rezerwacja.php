<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rezerwacja</title>
        <link href="https://fonts.googleapis.com/css?family=Eczar:700|Lato:400,700|Source+Sans+Pro:600,700,900" rel="stylesheet">
        <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css" integrity="sha384-Wrgq82RsEean5tP3NK3zWAemiNEXofJsTwTyHmNb/iL3dP/sZJ4+7sOld1uqYJtE"
            crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css\style.css">
        <link rel="stylesheet" type="text/css" href="css\rezerwacjaStyle.css">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
            crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <nav class="clear">
                <div class="left logo">
                    <a href="index.html"> Mazury.info</a>
                </div>
                <div class="right">
                    <ul>
                        <li><a href="index.html">Ogólne informacje</a></li>
                        <li><a href="szlakiWodne.html">Szlaki wodne</a></li>
                        <li><a href="galeria.html">Galeria</a></li>
                        <li><a href="noclegi.html">Noclegi</a></li>
                        <li><a href="rezerwacja.php">Rezerwacja</a></li>
                    </ul>
                </div>
            </nav>
        </header>
<?php
require_once 'initialize.php';
require_once 'dbUpdateHandler.php';
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
        <form id="js-reservationForm" class="reservationForm form-inline" name="reservationForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<?php
require_once 'dbSelectHandler.php';
?>
        <script src="js/script.js"></script>
    </body>
</html>