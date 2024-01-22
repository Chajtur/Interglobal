<?php

include_once '../models/LoB.php';

$lob = [
    "Commercial Auto",
    "Personal Auto",
    "General Liability",
    "Motor Truck Cargo",
    "Physical Damage",
    "Workers Compensation"
];

foreach ($lob as $key => $value) {
    $newLob = new LoB($value, 1);
    $newLob->create();
}

?>