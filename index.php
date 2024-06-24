<?php
session_start();
include("database/connection.php");
include("scripts/functions.php");

$config = $GLOBALS["config"];
$conn = connect_to_db($config);
$user = checkLogin($conn);
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sklep</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
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
                    <a class="nav-link active text-light" aria-current="page" href="#">Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="pages/about.php">O nas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-light" href="pages/shop.php">Sklep</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="pages/cart.php">Koszyk</a>
                </li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item">
                    <a class="nav-link text-light" href="pages/profile.php">Profil</a>
                </li>';
                    echo '<li class="nav-item">
                    <a class="nav-link text-light" href="../pages/logout.php">Wyloguj</a>
                </li>';
                } else {
                    echo '<li class="nav-item">
                    <a class="nav-link text-light" href="pages/login.php">Zaloguj się</a>
                </li>';
                }

                if (isset($_SESSION['role_id'])) {
                    if ($_SESSION['role_id'] > 1) {
                        echo '<li class="nav-item">
                    <a class="nav-link text-light" href="pages/admin.php">Panel Administracyjny</a>
                </li>';
                    }

                }
                ?>
            </ul>
            <form class="d-flex" role="search" action="pages/shop.php" method="get">
                <input class="form-control me-2 text-dark" type="search" placeholder="Szukaj przedmiotu"
                       aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Szukaj</button>
            </form>
        </div>
    </div>
</nav>

<!--   CONTENT    -->

<div class="container-fluid bg-black text-light" id="MeblexText">
    <div class="row text-left ms-1 display-1 gradient-text">
        <strong> MEBLEX</strong>
    </div>
    <div class="row text-left ms-3 display-5 secondary-gradient-text">
        Lider nr. 1 branży meblowej<br>
        w Sianowie.
    </div>


</div><!--   FOOTER    -->

<footer class="mt-5">

    <div class="row text-start ms-3 pt-5">
        Meblex <br>
        Sianowskie Centrum Mebli <br>
        Koszalińska 2, 76-100 Sianów <br>
        +48 923 567 123
    </div>

</footer>

<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>