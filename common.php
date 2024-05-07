<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/Login.php';


if (!function_exists('startSession'))
{
    function startSession()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
    }

}

if (!function_exists('checkActivity'))
{
    function checkActivity()
    {
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 28800 || !isset($_SESSION['last_activity']))
        {
            logOut();
            echo "<script>
                    modalShow('sesionExpirada');
              </script>";
        }
        $_SESSION['last_activity'] = time();
    }
}