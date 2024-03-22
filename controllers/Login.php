<?php

include_once '../models/User.php';
$user = new User();

$isLoggedIn = false;

if (isset($_GET['action']) || isset($_POST['action'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
        switch ($action) {
            case 'login':
                login();
                break;
            case 'logout':
                logOut();
                break;
            case 'getEmployeeList':
                getEmployeeList();
                break;
            case 'isLoggedIn':
                isLoggedIn();
                break;
            default:
                return 0;
        }
    } else {
        $action = $_GET['action'];
        switch ($action) {
            case 'getEmployeeList':
                getEmployeeList();
                break;
            case 'getEmployeeInfo':
                getEmployeeInfo();
                break;
            default:
                return 0;
        }
    }
}

function getEmployeeList()
{
    global $user;
    $users = $user::getActiveUsers();
    $resp = [];
    foreach ($users as $User) {
        $line['id'] = $User['id'];
        $line['fullName'] = $User['firstName'] . ' ' . $User['lastName'];
        $resp[] = $line;
    }
    echo json_encode($resp);
}

function getUser()
{
    return $_SESSION['employeeId'];
}

function getRole()
{
    return $_SESSION['user']['roles'];
}

function login()
{
    global $isLoggedIn;
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $employee = new User();
        $User = $employee->getEmployee($user);
        if (isset($User['password'])) {
            if (password_verify($pass, $User['password'])) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['employeeId'] = $User['id'];
                $isLoggedIn = true;
                echo 1;
                die();
            }
        }
    }
    echo 0;
}

function getEmployeeInfo()
{
    echo json_encode($_SESSION['user']);
}

function isLoggedIn()
{
    if (isset($_SESSION['isLoggedIn'])) {
        if ($_SESSION['isLoggedIn'] == true) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
}

function logOut()
{
    $_SESSION['isLoggedIn'] = false;
    session_unset();
    session_destroy();
}

function startSession()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

function checkActivity()
{
    global $PATH;
    if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 28800) {
        logOut();
        echo "<script>console.log('Sesión expirada, logging out...'); $('.modal').modal('hide'); $('#sesionExpirada').modal('show');</script>";
    }
    $_SESSION['last_activity'] = time();
}
