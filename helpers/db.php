<?php
if (!isset($_SESSION)) {
    session_start();
}

$servername = "23.21.145.240";
$username = "admin";
$password = "Xcphoky3";
$dbname = "interglobal";
$webKey = "?webKey=5a6f85d3d2a12d1f5c7f2566a2c75d9a751f4d79";
$apiBaseURL = "https://mobile.fmcsa.dot.gov/qc/services/";
$googleMapsApiKey = "AIzaSyAvoz1u2dRSfyimsYnF7bnbekygaulzZj8";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$environment = 'development';


if ($environment == 'development') {
    $PATH = 'http://localhost/crm';
} else {
    $PATH = 'app.interglobalus.com';
}
