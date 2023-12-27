<?php 

require_once('../controllers/Login.php');
startSession();
checkActivity();

    $module = isset($_POST['modulo']) ? $_POST['modulo'] : 'Content';

    switch($module) {
        case 'Calendario' :
            echo '<script type="text/javascript" src="../js/calendario.js"></script>';
            include "../views/calendario.php";
            break;
        case 'Content' :
            include "../views/content.php";
            break;
        case 'E-tickets' :
            include "../views/eticket.php";
            break;
        default :
            break;
    }
?>