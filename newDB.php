<?php
$newDatabase = 'hotelMazury';

// Create connection
$conn = new mysqli($adres, $user, $pass);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} 

$sql = "SET NAMES 'UTF8';";
if ($conn->query($sql) === TRUE) {
    echo 'SET NAMES UTF8 successfully';
} else {
    echo 'Error SET NAMES UTF8 ' . $conn->error;
}

// Create database
$sql = 'DROP DATABASE IF EXISTS hotelMazury;';
$sql .= "CREATE DATABASE hotelMazury CHARACTER SET = 'utf8';";

if ($conn->multi_query($sql) === TRUE) {
    echo 'Database re-created successfully';
} else {
    echo 'Error creating database and t klienci: ' . $conn->error;
}
$conn->close();


// Create connection
$conn = new mysqli($adres, $user, $pass, $newDatabase);
if ($conn->connect_error) {
    die('Connection to '.$newDatabase.' failed: ' . $conn->connect_error);
} 

$sql = "SET NAMES 'UTF8';";
if ($conn->query($sql) === TRUE) {
    echo 'SET NAMES UTF8 successfully';
} else {
    echo 'Error SET NAMES UTF8 ' . $conn->error;
}

$sql = "CREATE TABLE klienci (
        IDKlienta int(11) NOT NULL PRIMARY KEY,
        Nazwisko varchar(50) NOT NULL,
        Imie varchar(50) NOT NULL,
        email varchar(50) NOT NULL,
        telephone char(9) NOT NULL) 
        ENGINE=InnoDB;";

$sql .= "INSERT INTO `klienci` (`IDKlienta`, `Nazwisko`, `Imie`, `email`, `telephone`) VALUES
        (1, 'Doe', 'John', 'john@example.com', '123456789'),
        (2, 'Zapała', 'Grzegorz', 'zapala.grzegorz@gmail.com', '726360382');";

$sql .= "CREATE TABLE `pokoje` (
        `IdPokoju` int(11) NOT NULL PRIMARY KEY,
        `Cena` float NOT NULL,
        `RodzajPokoju` int(11) NOT NULL)
         ENGINE=InnoDB;";

$sql .= "INSERT INTO `pokoje` (`IdPokoju`, `Cena`, `RodzajPokoju`) VALUES
        (1, 140, 2),
        (2, 140, 2),
        (3, 140, 2),
        (4, 140, 2),
        (5, 140, 2),
        (6, 140, 2),
        (7, 160, 3),
        (8, 160, 3),
        (9, 160, 3),
        (10, 160, 3),
        (11, 160, 3),
        (12, 160, 3);";

$sql .= "CREATE TABLE `rezerwacje` (
        `IDRezerwacji` int(11) NOT NULL PRIMARY KEY,
        `IDPokoju` int(11) NOT NULL,
        `IDKlienta` int(11) NOT NULL,
        `DataPoczatkowa` date NOT NULL,
        `DataKoncowa` date NOT NULL)
         ENGINE=InnoDB;";


$sql .= "ALTER TABLE `rezerwacje`
  ADD KEY `IDPokoju` (`IDPokoju`),
  ADD KEY `IDKlienta` (`IDKlienta`);";


$sql .= "ALTER TABLE `klienci`
    MODIFY `IDKlienta` int(11) NOT NULL AUTO_INCREMENT;";


$sql .=  "ALTER TABLE `pokoje`
  MODIFY `IdPokoju` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;";

$sql .= "ALTER TABLE `rezerwacje`
    MODIFY `IDRezerwacji` int(11) NOT NULL AUTO_INCREMENT;";


$sql .= "ALTER TABLE `rezerwacje`
    ADD CONSTRAINT `rezerwacje_idKlienta` FOREIGN KEY (`IDKlienta`) REFERENCES `klienci` (`IDKlienta`),
    ADD CONSTRAINT `rezerwacje_idPokoju` FOREIGN KEY (`IDPokoju`) REFERENCES `pokoje` (`IdPokoju`);";

if ($conn->multi_query($sql) === TRUE) {
    echo 'tables created successfully';
} else {
    echo 'Error creating tables: ' . $conn->error;
}

$conn->close();
?>