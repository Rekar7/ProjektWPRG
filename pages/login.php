<?php
session_start();
include("../database/connection.php");
include("../scripts/functions.php");

$config = $GLOBALS["config"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!empty($email) && !empty($password)) {
        $conn = connect_to_db($config);
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (($result) && ($result->num_rows > 0)) {
                $userData = mysqli_fetch_assoc($result);

                if ($userData['password'] === $password) {
                    $_SESSION['user_id'] = $userData['user_id'];
                    $_SESSION['role_id'] = $userData['role_id'];
                    $_SESSION['name'] = $userData['name'];
                    $_SESSION['last_name'] = $userData['last_name'];
                    $_SESSION['phone_number'] = $userData['phone_number'];
                    $_SESSION['address'] = $userData['address'];
                    $_SESSION['email'] = $userData['email'];
                    $conn->close();
                    header("Location: ../index.php");
                    die;
                }
            }
        }
        $conn->close();
        die;
    } else {
        //echo "All fields are required";
    }
}
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
                    <a class="nav-link text-light" href="#">Zaloguj się</a>
                </li>
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

<div class="container-fluid text-light p-5" id="main-page">
    <div class="row text-center p-1">
        <h1>Zaloguj się</h1>
    </div>

    <div class="row text-center justify-content-center">

        <form action="#" method="POST" class="was-validated text-center w-50 mt-5">

            <!-- Email -->

            <div class="col">
                <label class="mt-3" for="emal">Email</label>
                <input name="email" type="email" class="form-control" placeholder="Email reprezentanta" required>
            </div>

            <!-- Hasło -->

            <div class="col mt-3">
                <label for="password">Hasło</label>
                <input name="password" type="password" class="form-control " placeholder="Hasło" required>
            </div>

            <!-- submit -->
            <input type="submit" class="btn btn-lg btn-block btn-primary mt-5" value="Wyślij formularz"></input>

        </form>
    </div>

    <div class="row text-center justify-content-center mt-5">
        Nie masz konta? Zarejestruj się <a href="../pages/register.php">tu!</a>
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
