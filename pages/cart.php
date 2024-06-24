<?php
session_start();
include("../database/connection.php");
include("../scripts/functions.php");

$config = $GLOBALS["config"];
$conn = connect_to_db($config);
checkLogin($conn);

var_dump($_POST);

if (isset($_POST["product"])) {
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart']);
        array_push($cart, $_POST["product"]);
        setcookie("cart", json_encode($cart), time() + (86400 * 30), "/");   //cookie odnawia się za każdym razem jak się dodaje do koszyka
    } else {
        $cart = array($_POST["product"]);
        setcookie("cart", json_encode($cart), time() + (86400 * 5), "/");  //cookie będzie trwał 5 dni
    }

}
echo "cook";
var_dump($_COOKIE['cart']);
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
                    <a class="nav-link text-light" href="#">Koszyk</a>
                </li>
                <?php
                showLoginProfile();
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

<?php

if (isset($_COOKIE['cart'])) {
    $cart = json_decode($_COOKIE['cart'], true);
    $conn = connect_to_db($config);
    $products = (object) array();
    foreach ($cart as $product) {
        $query = "SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_name = '" . $product . "';";
        $result = loadProducts($conn, $query);
        if ($result) {
            $products = array_merge($products, $result);
        }
    }
    $conn->close();

}
?>


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
