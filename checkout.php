<?php

session_start();

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subtotal = array_sum(array_column($_SESSION['cart'], 'price'));
    $vat = $subtotal * 0.21;
    $total = $subtotal + $vat;

    $stmt = $pdo->prepare("INSERT INTO orders (subtotal, vat, total) VALUES (?, ?, ?)");
    $stmt->execute([$subtotal, $vat, $total]);
    $orderId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO cart_items (domain, price, order_id) VALUES (?, ?, ?)");
    foreach ($_SESSION['cart'] as $item) {
        $stmt->execute([$item['domain'], $item['price'], $orderId]);
    }

    $_SESSION['cart'] = [];
    header('Location: orders.php');
    exit();
}
?>