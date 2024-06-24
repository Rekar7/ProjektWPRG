<?php
$config = $GLOBALS["config"];

enum Category: string
{
    case SALON = 'Salon';
    case SYPIALNIA = 'Sypialnia';
    case BIURO = 'Biuro';
    case JADALNIA = 'Jadalnia';
    case KUCHNIA = 'Kuchnia';
    case NAZEWNĄTRZ = 'Na zewnątrz';
    case ŁAZIENKA = 'Łazienka';
    case DZIECI = 'Dzieci';
    case DEKORACJE = 'Dekoracje';
    case PRZECHOWYWANIE = 'Przechowywanie';
    case PRZEDPOKÓJ = 'Przedpokój';
    case OŚWIETLENIE = 'Oświetlenie';
    case MATERACE = 'Materace';
}

function checkLogin($conn)
{
    if (isset($_SESSION['userId'])) {
        $id = $_SESSION['userId'];
        $query = "SELECT * FROM users WHERE user_id='$id'";

        $result = mysqli_query($conn, $query);
        if (($result) && ($result->num_rows > 0)) {
            $user_data = mysqli_fetch_assoc($result);
            $conn->close();
            return $user_data;
        }
    }

    $conn->close();
    return false;
}

function showAdminPanel()
{
    if (isset($_SESSION['role_id'])) {
        if ($_SESSION['role_id'] > 1) {
            echo '<li class="nav-item">
                    <a class="nav-link text-light" href="../pages/admin.php">Panel Administracyjny</a>
                </li>';
        }
    }
}

function showLoginProfile()
{
    if (isset($_SESSION['user_id'])) {
        echo '<li class="nav-item">
                    <a class="nav-link text-light" href="../pages/profile.php">Profil</a>
                </li>';
    } else {
        echo '<li class="nav-item">
                    <a class="nav-link text-light" href="../pages/login.php">Zaloguj się</a>
                </li>';
    }
}

function showLogout()
{
    if (isset($_SESSION['user_id'])) {
        echo '<li class="nav-item">
                    <a class="nav-link text-light" href="../pages/logout.php">Wyloguj</a>
                </li>';
    }
}

class Product
{
    public $productId;
    public $productName;
    public $price;
    public $stockQuantity;
    public $category;
    public $image;

    function __construct($productId, $productName, $price, $stockQuantity, $category, $image)
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->price = $price;
        $this->stockQuantity = $stockQuantity;
        $this->category = $category;
        $this->image = $image;
    }

    public function showProduct()
    {
        echo "<div class='shopItem justify-content-center text-center mt-2'><form action='../pages/product.php' method='get'><input type='hidden' name='product' value='" . $this->productName . "'><button type='submit'><img src='../assets/" . $this->image . "'>
<br>" . $this->productName . "<br>cena: " . $this->price . "zł<br>ilość: " . $this->stockQuantity . "</button></form></div>";
    }


}

;

function getProduct()
{
    $config = $GLOBALS["config"];
    $conn = connect_to_db($config);
    $query = "SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_name = '" . $_GET['product'] . "';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $product = new Product($row['product_id'], $row['product_name'], $row['price'], $row['stock_quantity'], $row['category_name'], $row['image']);
    $conn->close();

    return $product;
}

function addToCart()
{
    $product = getProduct();
    if ($product->stockQuantity > 0) {
        echo "<div class='col me-5 pe-5''><form action='../pages/cart.php' method='post'><input type='hidden' name='product' value='" . $product->productName . "'><button class='btn btn-outline-light' type='submit'>Dodaj do koszyka</button></form></div>";
    } else {
        echo "<div class='col me-5 pe-5''><button class='btn btn-outline-light disabled'>Dodaj do koszyka</button></div>";
    }
}

function deleteProduct()
{
    if (isset($_GET['product']) && isset($_GET['delete']) && $_GET['delete'] == 'true') {
        $config = $GLOBALS["config"];
        $conn = connect_to_db($config);
        $query = "DELETE FROM products WHERE product_id='" . $_GET['product'] . "';";
        mysqli_query($conn, $query);
    }
}

function deleteProductButton()
{
    if (isset($_SESSION['user_id']) && $_SESSION['role_id'] > 2) {
        echo "<div class='col me-5 pe-5 ms-5 ps-5''><form action='../pages/shop.php' method='post'><input type='hidden' name='product' value='" . $_GET['product'] . "'><input type='hidden' name='delete' value='true'><button class='btn btn-outline-light btn-danger' type='submit'>Usun produkt ze sklepu</button></form></div>";
    }
}

function showProductDetail()
{
    $product = getProduct();
    echo "<div class='col ms-5 me-5 pe-5'><img class='border border-dark border-3' id='productImage' src='../assets/" . $product->image . "'></div>";
    echo "<div class='col ms-5 ps-5'>
            <h2>Nazwa: " . $product->productName . "</h2><br>
            <h2>Cena: " . $product->price . "</h2><br>
            <h2>Ilość: " . $product->stockQuantity . "</h2><br>
            <h2>Kategoria: " . $product->category . "</h2><br>
</div>";
}

function loadProducts($conn, $query)
{

    $result = mysqli_query($conn, $query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $product = new Product($row['product_id'], $row['product_name'], $row['price'], $row['stock_quantity'], $row['category_name'], $row['image']);
        $products[] = $product;
    }

    $conn->close();

    return $products;
}


function compareByPriceAscending($a, $b)
{
    // Replace 'fieldName' with the actual field you want to sort by
    return $a->price < $b->price;
}

function compareByPriceDescending($a, $b)
{
    return $a->price > $b->price;
}

function compareByNameAscending($a, $b)
{
    return $a->productName <=> $b->productName;
}

function compareByAvailability($a, $b)
{
    return $a->stockQuantity < $b->stockQuantity;
}

?>