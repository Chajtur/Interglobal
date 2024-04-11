<?php
session_start();
define('ROOT_DIR', realpath(dirname(__FILE__)));
$_SESSION['root'] = ROOT_DIR;
?>
<!doctype html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.3/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> -->
    <script src="https://kit.fontawesome.com/55b2ee1815.js" crossorigin="anonymous"></script>
    <script src="../js/index.js"></script>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    
    <link rel="stylesheet" href="../css/tailwind.css">
    <!-- <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="../css/index.css">

    <title>
        INTERGLOBAL INSURANCE CO. | US TRUCKING FOR HIRE
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="icon" href="https://interglobalus.com/wp-content/uploads/2021/12/cropped-LOGO-INTERGLOBAL-01-270x270.png">
</head>

<body id="allContent" class="flex h-screen w-screen bg-slate-100">
    <?php
    require "../controllers/Login.php";
    startSession();
    if (isset($_SESSION['isLoggedIn'])) {
        if ($_SESSION['isLoggedIn'] != true) {
            include 'login.php';
        } else {
            include 'main.php';
        }
    } else {
        include 'login.php';
    }
    ?>
</body>

<script src="../js/index.js"></script>