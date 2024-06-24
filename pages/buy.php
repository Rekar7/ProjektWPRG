<?php
session_start();
include("../database/connection.php");
include("../scripts/functions.php");

$config = $GLOBALS["config"];
$conn = connect_to_db($config);
checkLogin($conn);

$canBuy = false;
if (isset($_COOKIE['cart']) && isset($_SESSION['user_id'])) {
    $canBuy = true;
    $cart = json_decode($_COOKIE['cart'], true);   //cookie odnawia się za każdym razem jak się dodaje do koszyka
    if (!is_array($cart)) {
        $cart = []; // Jeśli json_decode zwróci coś innego niż tablica, ustaw $cart jako pustą tablicę
    }

    $products = [];


    foreach ($cart as $product_name) {
        $conn = connect_to_db($config);
        $query = "
                SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_name = '" . $product_name . "'";
        $product = loadProducts($conn, $query);
        $products = array_merge($products, $product);
    }

    $totalPrice = 0;
    foreach ($products as $product) {
        $totalPrice += $product->price;
    }

    $conn = connect_to_db($config);

    $query = "INSERT INTO orders (user_id, order_date, total_price) VALUES (" . $_SESSION['user_id'] . ", NOW(), " . $totalPrice . ");";
    mysqli_query($conn, $query);

    $query = "SELECT * FROM orders ORDER BY order_id DESC LIMIT 1;";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_array($result);

    foreach ($products as $product) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
              (" . $order['order_id'] . ", '" . $product->productId . "', 1, " . $product->price . ");";
        mysqli_query($conn, $query);
    }

    setcookie('cart', json_encode($cart), time() - 3600, "/");
    $conn->close();
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
<div class="container-fluid justify-content-center m-auto">
<?php

if (!$canBuy) {
    echo "<div class='container-fluid bg-black'>Musisz się zalogować i mieć coś w koszyku, żeby móc dokonać zakupu!</div>";
} else {
    $conn = connect_to_db($config);
    $query = "
                SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN order_items oi on p.product_id = oi.product_id
                JOIN categories c ON p.category_id = c.category_id
                WHERE oi.order_id=" . $order['order_id'] . ";";
    $products = loadProducts($conn, $query);

    echo "<div class='grid-container bg-success w-75'>";

    foreach ($products as $product) {
        $product->showProduct();
    }
    echo "</div>";
}

?>
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