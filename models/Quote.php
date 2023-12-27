<?php

//include '../models/Mailer.php';

$servername = "23.21.145.240";
$username = "admin";
$password = "Xcphoky3";
$dbname = "interglobal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insertQuote($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, $status, $ownersName) {
    Global $conn;
    $query = "insert into Quotes (date, name, dot, mc, address, city, state, zip, email, phone, proposedDate, driverLicense, status, owner) values (NOW(), '$name', $dot, $mc, '$address', '$city', '$state', $zip, '$email', $phone, '$proposedDate', '$driverLicense', '$status', '$ownersName')";
    $resp = $conn -> query($query);
    if ($resp == 1) {
        sendRequestQuoteMail($name, $dot, $mc, $address, $city, $state, $zip, $email, $phone, $proposedDate, $driverLicense, $status, $ownersName);
    }
    return $resp;
}

function loadQuotes($agent) {
    Global $conn;
    $query = "select * from Quotes where agent = $agent and status = 'requested'";
    $datosObj = $conn->query($query);
    $resp = mysqli_fetch_all($datosObj, MYSQLI_ASSOC);
    return $resp;
}