<?php
session_start();
include("../database/connection.php");
include("../scripts/functions.php");

$config = $GLOBALS["config"];
$conn = connect_to_db($config);
checkLogin($conn);
deleteProduct();
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
                    <a class="nav-link text-light" href="#">Sklep</a>
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
            <form class="d-flex" role="search" action="../pages/shop.php" method="post">
                <input class="form-control me-2 text-dark" name="search" type="search" placeholder="Szukaj przedmiotu"
                       aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Szukaj</button>
            </form>
        </div>
    </div>
</nav>

<!--   CONTENT    -->

<div class="container mt-5">
    <!-- **Tutaj może znajdować się zawartość strony, np. produkty sklepu** -->
    <div class="flex-container">

        <div class="flex-container-vertical sidebars me-2 bg-dark-subtle">
            <div class="border border-dark border-3 p-1 text-dark"><H5>Kategorie</H5></div>
            <?php

            foreach (Category::cases() as $category) {
                echo '<div class="border border-dark border-3 p-1 text-dark"><form action="../pages/shop.php" method="get"><input type="hidden" name="category" value="' . $category->value . '"><button type="submit">  ' . $category->value . '</button></form></div>';
            }

            ?>
        </div>
        <div class="grid-container bg-success w-75">
            <?php

            $products = (object)array();
            $conn = connect_to_db($config);
            if (isset($_POST['search'])) {
                $query = "
                SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_name LIKE '%" . $_POST['search'] . "%'";
                $products = loadProducts($conn,$query);
            } else {
                $query = "
                SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN categories c ON p.category_id = c.category_id";
                $products = loadProducts($conn,$query);
            }
            if (isset($_GET["category"])) {
                foreach ($products as $product) {
                    if ($product->category == $_GET['category']) $product->showProduct();
                }
            } else {

                if (isset($_GET['sort'])) {
                    switch ($_GET['sort']) {
                        case "priceDescending":
                            usort($products, 'compareByPriceAscending');
                            break;
                        case "priceAscending":
                            usort($products, 'compareByPriceDescending');
                            break;
                        case "nameDescending":
                            usort($products, 'compareByNameAscending');
                            $products = array_reverse($products);
                            break;
                        case "nameAscending":
                            usort($products, 'compareByNameAscending');
                            break;
                        case "availability":
                            usort($products, 'compareByAvailability');
                            break;
                        default:
                            break;
                    }
                }

                foreach ($products as $product) {
                    $product->showProduct();
                }
            }

            ?>
        </div>
        <div class="flex-container-vertical sidebars ms-2 bg-dark-subtle">
            <div class="border border-dark border-3 p-1 text-dark"><H5>Sortowanie</H5></div>
            <div class="border border-dark border-3 p-1 text-dark">
                <form action="../pages/shop.php" method="get"><input type="hidden" name="sort" value="priceDescending">
                    <button type="submit">Cena malejąca</button>
                </form>
            </div>
            <div class="border border-dark border-3 p-1 text-dark">
                <form action="../pages/shop.php" method="get"><input type="hidden" name="sort" value="priceAscending">
                    <button type="submit">Cena rosnąca</button>
                </form>
            </div>
            <div class="border border-dark border-3 p-1 text-dark">
                <form action="../pages/shop.php" method="get"><input type="hidden" name="sort" value="nameDescending">
                    <button type="submit">Nazwa malejąca</button>
                </form>
            </div>
            <div class="border border-dark border-3 p-1 text-dark">
                <form action="../pages/shop.php" method="get"><input type="hidden" name="sort" value="nameAscending">
                    <button type="submit">Nazwa rosnąca</button>
                </form>
            </div>
            <div class="border border-dark border-3 p-1 text-dark">
                <form action="../pages/shop.php" method="get"><input type="hidden" name="sort" value="availability">
                    <button type="submit">dostępność</button>
                </form>
            </div>
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
