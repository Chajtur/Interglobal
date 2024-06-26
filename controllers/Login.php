<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
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
            case 'changePassword':
                changePassword($_POST['password'], $_POST['passwordChange']);
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

/** 
 * Function to get the list of active employees
 * 
 * @return JSON
*/
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

/**
 * Function to get the user id
 * 
 * @return int
 */
function getUser()
{
    return $_SESSION['employeeId'];
}

function getRole()
{
    return $_SESSION['user']['roles'];
}

/**
 * Function to log in the user
 * 
 * @return int
 * 1 = Success
 * 0 = Fail
 * 
 * @global boolean $isLoggedIn
 * @global array $_SESSION
 * @global User $employee
 * @global array $User
 * @global string $user
 * @global string $pass
 * @global boolean
 */
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
                $_SESSION['last_activity'] = time();
                $_SESSION['offset'] = -6;
                $isLoggedIn = true;
                echo 1;
                die();
            }
        }
    }
    echo 0;
}

/**
 * Function to get the user information
 * 
 * @return JSON
 */
function getEmployeeInfo()
{
    echo json_encode($_SESSION['user']);
}

/**
 * Function to check if the user is logged in
 * 
 * @return int
 * 1 = Logged in
 * 0 = Not logged in
 */
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

/**
 * Function to log out the user
 */
function logOut()
{
    $_SESSION['isLoggedIn'] = false;
    session_unset();
    session_destroy();
}

/**
 * Function to update a user password
 * @string $password - The new password
 * @string $passwordChange - The password change token
 * 
 * @return int
 */
function changePassword($password, $passwordChange)
{
    global $user;
    $user->loadByPasswordChange($passwordChange);
    if ($user->id > 0) {
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $updated = $user->update();
        if ($updated) {
             $resp['status'] = 'success';
            $resp['message'] = 'Password updated successfully';
        } else {
        $resp['status'] = 'error';
        $resp['message'] = 'Invalid password change token';
        };
    } else {
        $resp['status'] = 'error';
        $resp['message'] = 'Invalid password change token';
    }
    echo json_encode($resp);
}