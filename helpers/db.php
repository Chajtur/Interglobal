<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
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

    $environment = 'development';


    if ($environment == 'development') {
        $PATH = 'http://localhost/crm';
    } else {
        $PATH = 'app.interglobalus.com';
    }
?>