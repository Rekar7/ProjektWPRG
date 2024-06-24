<?php
session_start();

if (isset($_POST['product'])) {
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
        $cart = array_filter($cart, function($item) {
            return $item != $_POST['product'];
        });
        setcookie("cart", json_encode($cart), time() + (86400 * 5), "/"); // Update the cookie
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit;
?>
