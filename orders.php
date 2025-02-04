<?php

session_start();

require_once 'connection.php';

$stmt = $pdo->query("SELECT * FROM orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellingen</title>
</head>
<body>
    <h1>Bestellingen</h1>
    <ul>
        <?php foreach ($orders as $order) { ?>
            <li>
                Order #<?= $order['id'] ?> - Subtotaal: €<?= $order['subtotal'] ?> - BTW: €<?= $order['vat'] ?> - Totaal: €<?= $order['total'] ?> - Datum: <?= $order['created_at'] ?>
                <button onclick="window.location.href='index.php'">Home page</button>
            </li>
        <?php } ?>
    </ul>
</body>
</html>