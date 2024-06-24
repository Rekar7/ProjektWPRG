<?php
if (isset($_POST["product"])) {
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);   //cookie odnawia się za każdym razem jak się dodaje do koszyka
        if (!is_array($cart)) {
            $cart = []; // Jeśli json_decode zwróci coś innego niż tablica, ustaw $cart jako pustą tablicę
        }
    } else {
        $cart = [];  //cookie będzie trwał 5 dni
    }
    array_push($cart, $_POST["product"]);
    setcookie("cart", json_encode($cart), time() + (86400 * 5), "/"); // 5-day cookie

    // Redirect to avoid resubmission
    header("Location: cart.php");
    exit;
}

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


<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <h2>Koszyk</h2>
            <table class="table table-dark table-striped">
                <thead>
                <tr>
                    <th>Nazwa produktu</th>
                    <th>Cena</th>
                    <th>Ilość</th>
                    <th>Akcje</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($_COOKIE['cart'])) {
                    $cart = json_decode($_COOKIE['cart'], true);
                    if (!empty($cart)) {
                        $conn = connect_to_db($config);
                        foreach ($cart as $product_name) {
                            $query = "SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                                      FROM products p
                                      JOIN categories c ON p.category_id = c.category_id
                                      WHERE p.product_name = '" . $product_name . "'";
                            $result = mysqli_query($conn, $query);
                            if ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['product_name']}</td>
                                        <td>{$row['price']} zł</td>
                                        <td>1</td>
                                        <td><form action='remove_from_cart.php' method='post'><input type='hidden' name='product' value='{$row['product_name']}'><button type='submit' class='btn btn-danger'>Usuń</button></form></td>
                                      </tr>";
                            }
                        }
                        $conn->close();
                    } else {
                        echo "<tr><td colspan='4'>Koszyk jest pusty.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Koszyk jest pusty.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
//
//if (isset($_COOKIE['cart'])) {
//    $cart = $_COOKIE['cart'];
//    $conn = connect_to_db($config);
//    $products = (object) array();
//    foreach ($cart as $product) {
//        $query = "SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
//                FROM products p
//                JOIN categories c ON p.category_id = c.category_id
//                WHERE p.product_name = '" . $product . "';";
//        $result = loadProducts($conn, $query);
//        if ($result) {
//            $products = array_merge($products, $result);
//        }
//    }
//    $conn->close();
//
//}
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
