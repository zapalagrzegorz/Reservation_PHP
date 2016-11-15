<?php
$firstName = $lastName = $email = $telephone = $roomStartDateRaw = $roomStartDate = $roomEndsDate = $roomEndsDateRaw = "";
$firstNameErr = $lastNameErr = $emailErr = $telephoneErr = $quantityDoubleRoomErr= "";
$extraBedDoubleRoom = $doubleRoom = false;
$quantityDoubleRoom = 0;
$roomNumber = 0;
$db = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {

    if( !empty($_GET['doubleRoomStartDate']) ) {
        $roomStartDateRaw = htmlentities($_GET['doubleRoomStartDate']);
        $roomStartDate = date('Y-m-d', strtotime($roomStartDateRaw));
        $roomStartDate = $_GET['doubleRoomStartDate'];

        $roomEndsDateRaw = htmlentities($_GET['doubleRoomEndsDate']);
        $roomEndsDate = date('Ymd', strtotime($roomEndsDateRaw));
        $roomEndsDate = $_GET['doubleRoomEndsDate'];
    }
}   
?>