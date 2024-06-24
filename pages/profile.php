<?php
session_start();
include("../database/connection.php");
include("../scripts/functions.php");

$config = $GLOBALS["config"];
$conn = connect_to_db($config);
checkLogin($conn);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sklep</title>
    <link href="../bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="bg-black text-light">

<!--   NAVBAR    -->

<nav class="navbar navbar-expand-lg bg-body-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-light" href="#">MEBLEX</a>
        <button class="navbar-toggler bg-light-subtle" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-light" aria-current="page" href="../index.php">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="../pages/about.php">O nas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-light" href="../pages/shop.php">Sklep</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="../pages/cart.php">Koszyk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#">Profil</a>
                </li>
                <?php
                showLogout();
                showAdminPanel();
                ?>
            </ul>
            <form class="d-flex" role="search" action="../pages/shop.php" method="get">
                <input class="form-control me-2 text-dark" type="search" placeholder="Szukaj przedmiotu"
                       aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Szukaj</button>
            </form>
        </div>
    </div>
</nav>

<!--   CONTENT    -->

<div class="container mt-5">
    <div class="row justify-content-start mt-5">
        Imię: <?php if(isset($_SESSION['name']))
        {
            echo $_SESSION['name'];
        }?>
    </div>
    <div class="row justify-content-start mt-5">
        Nazwisko: <?php if(isset($_SESSION['name']))
        {
            echo $_SESSION['name'];
        }?>
    </div>
    <div class="row justify-content-start mt-5">
        E-mail: <?php if(isset($_SESSION['email']))
        {
            echo $_SESSION['email'];
        }?>
    </div>
    <div class="row justify-content-start mt-5">
        Telefon: <?php if(isset($_SESSION['phone_number']))
        {
            echo $_SESSION['phone_number'];
        }?>
    </div>
    <div class="row justify-content-start mt-5">
        Adres: <?php if(isset($_SESSION['address']))
        {
            echo $_SESSION['address'];
        }?>
    </div>
    <div class="row justify-content-start mt-5">
        Rola: <?php if(isset($_SESSION['role_id']))
        {
            $conn = connect_to_db($config);
            $query="SELECT role_name FROM roles WHERE role_id = {$_SESSION['role_id']}";
            $result = $conn->query($query);
            $result = $result->fetch_assoc();
            echo $result["role_name"];
            $conn->close();
        }?>
    </div>
</div>

<!--   FOOTER    -->

<footer class="mt-5">

    <div class="row text-start ms-3 pt-5">
        Meblex <br>
        Sianowskie Centrum Mebli <br>
        Koszalińska 2, 76-100 Sianów <br>
        +48 923 567 123
    </div>

</footer>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>
