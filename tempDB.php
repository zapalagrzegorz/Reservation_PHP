
// SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
// SET time_zone = "+00:00";




// --
// -- Baza danych: `hoteltestdb`
// --

// -- --------------------------------------------------------

// --
// -- Struktura tabeli dla tabeli `klienci`
// --

// CREATE TABLE `klienci` (
//   `IDKlienta` int(11) NOT NULL,
//   `Nazwisko` varchar(50) CHARACTER SET cp1250 COLLATE cp1250_polish_ci NOT NULL,
//   `Imie` varchar(50) CHARACTER SET latin1 NOT NULL,
//   `email` varchar(50) CHARACTER SET latin1 NOT NULL,
//   `telephone` char(9) CHARACTER SET latin1 NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
+++++++++++++++++++



// --
// -- Zrzut danych tabeli `klienci`
// --

// INSERT INTO `klienci` (`IDKlienta`, `Nazwisko`, `Imie`, `email`, `telephone`) VALUES
// (2, 'Doe', 'John', 'john@example.com', '123456789'),
// (3, 'Doe', 'John', 'john@example.com', '123456789'),
// (22, 'Zapała', 'Grzegorz', 'zapala.grzegorz@gmail.com', '726360382'),
// (23, 'Zapała2', 'Grzegorz', 'zapala.grzegorz@gmail.com', '726360382');

// -- --------------------------------------------------------

// --
// -- Struktura tabeli dla tabeli `pokoje`
// --

// CREATE TABLE `pokoje` (
//   `IdPokoju` int(11) NOT NULL,
//   `Cena` float NOT NULL,
//   `RodzajPokoju` int(11) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

// --
// -- Zrzut danych tabeli `pokoje`
// --

// INSERT INTO `pokoje` (`IdPokoju`, `Cena`, `RodzajPokoju`) VALUES
// (1, 140, 2),
// (2, 140, 2),
// (3, 140, 2),
// (4, 140, 2),
// (5, 140, 2),
// (6, 140, 2),
// (7, 160, 3),
// (8, 160, 3),
// (9, 160, 3),
// (10, 160, 3),
// (11, 160, 3),
// (12, 160, 3);

// -- --------------------------------------------------------

// --
// -- Struktura tabeli dla tabeli `rezerwacje`
// --

// CREATE TABLE `rezerwacje` (
//   `IDRezerwacji` int(11) NOT NULL,
//   `IDPokoju` int(11) NOT NULL,
//   `IDKlienta` int(11) NOT NULL,
//   `DataPoczatkowa` date NOT NULL,
//   `DataKoncowa` date NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

// --
// -- Zrzut danych tabeli `rezerwacje`
// --

// INSERT INTO `rezerwacje` (`IDRezerwacji`, `IDPokoju`, `IDKlienta`, `DataPoczatkowa`, `DataKoncowa`) VALUES
// (1, 1, 2, '2016-11-11', '2016-11-12'),
// (23, 2, 22, '2016-11-11', '2016-11-13'),
// (24, 3, 22, '2016-11-11', '2016-11-13'),
// (25, 4, 22, '2016-11-11', '2016-11-13'),
// (26, 5, 22, '2016-11-11', '2016-11-13'),
// (27, 4, 22, '2016-11-11', '2016-11-13'),
// (28, 5, 22, '2016-11-11', '2016-11-13'),
// (29, 4, 22, '2016-11-11', '2016-11-13'),
// (30, 5, 22, '2016-11-11', '2016-11-13'),
// (31, 4, 22, '2016-11-11', '2016-11-13'),
// (32, 5, 22, '2016-11-11', '2016-11-13'),
// (33, 4, 22, '2016-11-11', '2016-11-13'),
// (34, 5, 22, '2016-11-11', '2016-11-13'),
// (35, 6, 22, '2016-11-11', '2016-11-13'),
// (37, 7, 22, '2016-11-11', '2016-11-13'),
// (38, 8, 22, '2016-11-11', '2016-11-13'),
// (39, 9, 22, '2016-11-11', '2016-11-13'),
// (40, 10, 22, '2016-11-11', '2016-11-13'),
// (41, 11, 22, '2016-11-11', '2016-11-13'),
// (42, 12, 22, '2016-11-11', '2016-11-13'),
// (43, 1, 22, '2016-11-13', '2016-11-14'),
// (44, 2, 22, '2016-11-13', '2016-11-14'),
// (45, 1, 22, '2016-11-13', '2016-11-14'),
// (46, 2, 22, '2016-11-13', '2016-11-14'),
// (47, 1, 22, '2016-11-13', '2016-11-14'),
// (48, 2, 22, '2016-11-13', '2016-11-14');

// --
// -- Indeksy dla zrzutów tabel
// --

// --
// -- Indexes for table `klienci`
// --
// ALTER TABLE `klienci`
//   ADD PRIMARY KEY (`IDKlienta`);

// --
// -- Indexes for table `pokoje`
// --
// ALTER TABLE `pokoje`
//   ADD PRIMARY KEY (`IdPokoju`);

// --
// -- Indexes for table `rezerwacje`
// --
// ALTER TABLE `rezerwacje`
//   ADD PRIMARY KEY (`IDRezerwacji`),
//   ADD KEY `IDPokoju` (`IDPokoju`),
//   ADD KEY `IDKlienta` (`IDKlienta`);

// --
// -- AUTO_INCREMENT for dumped tables
// --

// --
// -- AUTO_INCREMENT dla tabeli `klienci`
// --
// ALTER TABLE `klienci`
//   MODIFY `IDKlienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
// --
// -- AUTO_INCREMENT dla tabeli `pokoje`
// --
// ALTER TABLE `pokoje`
//   MODIFY `IdPokoju` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
// --
// -- AUTO_INCREMENT dla tabeli `rezerwacje`
// --
// ALTER TABLE `rezerwacje`
//   MODIFY `IDRezerwacji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
// --
// -- Ograniczenia dla zrzutów tabel
// --

// --
// -- Ograniczenia dla tabeli `rezerwacje`
// --
// ALTER TABLE `rezerwacje`
//   ADD CONSTRAINT `rezerwacje_idKlienta` FOREIGN KEY (`IDKlienta`) REFERENCES `klienci` (`IDKlienta`),
//   ADD CONSTRAINT `rezerwacje_idPokoju` FOREIGN KEY (`IDPokoju`) REFERENCES `pokoje` (`IdPokoju`);
// ?>


<fieldset>
                <legend class="centerText" style="padding-top: 20px">Rezerwacja</legend>
                <div class="centerText">
                    <label class="formName" for="firstName">Imię:</label>
                    <input type="text" name="firstName" value="<?php echo $firstName;?>" id="firstName" class="form-control" >
                    <span class="error">* <?php echo $firstNameErr;?></span>
                    <span>Nazwisko</span>
                    <input type="text" name="lastName" value="<?php echo $lastName;?>" class="form-control" >
                    <span class="error">* <?php echo $lastNameErr;?></span>
                </div>
                <div class="centerText">
                    <span>Telefon</span>
                    <input type="text" name="telephone" value="<?php echo $telephone;?>" class="form-control">
                    <span class="error">* <?php echo $telephoneErr;?></span>
                    <span>E-mail</span> 
                    <input id="emailInput" type="text" name="email" value="<?php echo $email;?>"  class="form-control">
                    <span class="error">* <?php echo $emailErr;?></span>
                </div>
                <div class="hidden">
                    <input type="date" name="roomStartDate" value="<?php echo $roomStartDate;?>">
                    <input type="date" name="roomEndsDate" value="<?php echo $roomEndsDate;?>">
                </div>
                <div class="wrap">
                    <!-- checkbox jest jako switch niezbedny do odroznienia czy wysyłane dane maja być przetwarzane jako rezerwacja -->
                    <input class="hidden" type="checkbox" name="updateDB" id="updateDBCheckbox">
                    <input class="btn btn-success" type="submit" id="js-updateDBButton" value="Rezerwuj">
                    <p><?php echo "The time is " . date("h:i:sa");  ?></p>
                </div>
            </fieldset>
        </form>