<?php

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

class Product
{
    public $productId;
    public $productName;
    public $categoryId;
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
        echo "<div class='shopItem justify-content-center text-center mt-2'><img src='../assets/" . $this->image . "'><br>" . $this->productName . "<br>cena: " . $this->price . "zł</div>";
    }

}

;

function loadProducts($conn)
{

    $query = "
            SELECT p.product_id, p.product_name, p.price, p.stock_quantity, c.category_name, p.image
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
        ";

    $result = mysqli_query($conn, $query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $product = new Product($row['product_id'], $row['product_name'], $row['price'], $row['stock_quantity'], $row['category_name'], $row['image']);
        $products[] = $product;
    }

    $conn->close();

    return $products;
}


?>