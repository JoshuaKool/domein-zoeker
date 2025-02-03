<?php

session_start();
require_once 'api-call.php';
require_once 'connection.php';

$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain = $_POST['domain'];
    $tlds = ['com', 'net', 'org', 'info', 'biz', 'us', 'co', 'io', 'nl', 'de'];
    $domains = array_map(function($tld) use ($domain) {
        return ['name' => $domain, 'extension' => $tld];
    }, $tlds);

    $searchResults = searchDomain($domains);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domein Zoeker</title>
</head>
<body>
    <h1>Domein Zoeker</h1>
    <form action="index.php" method="post">
        <label for="domain">Domein:</label>
        <input type="text" id="domain" name="domain" required>
        <button type="submit">Zoek</button>
    </form>
    <?php if (!empty($searchResults)) { ?>
        <h2>Resultaat</h2>
        <ul>
            <?php foreach ($searchResults as $result) {
                if (isset($result['domain']) && (is_string($result['domain']) || is_array($result['domain']))) {
                    $domain = is_array($result['domain']) ? implode('.', $result['domain']) : $result['domain'];
                    $price = isset($result['product']['price']) ? $result['product']['price'] : (isset($result['price']['product']['price']) ? $result['price']['product']['price'] : 'N/A');
                    ?>
                    <li>
                        <?= htmlspecialchars((string)$domain) ?> - <?= htmlspecialchars($result['status']) ?> - €<?= htmlspecialchars((string)$price) ?>
                        <?php if ($result['status'] === 'free') { ?>
                            <form action="add_to_cart.php" method="post" style="display:inline;">
                                <input type="hidden" name="domain" value="<?= htmlspecialchars((string)$domain) ?>">
                                <input type="hidden" name="price" value="<?= htmlspecialchars((string)$price) ?>">
                                <button type="submit">Toevoegen aan winkelmand</button>
                            </form>
                        <?php } ?>
                    </li>
                <?php } else { ?>
                    <li>Invalid result format</li>
                <?php } ?>
            <?php } ?>
        </ul>
    <?php } ?>
    <h2>Winkelmand</h2>
    <?php if (!empty($_SESSION['cart'])) { ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $index => $item) { ?>
                <li>
                    <?= htmlspecialchars($item['domain']) ?> - €<?= htmlspecialchars($item['price']) ?>
                    <form action="remove_from_cart.php" method="post" style="display:inline;">
                        <input type="hidden" name="index" value="<?= $index ?>">
                        <button type="submit">Verwijderen</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
        <form action="checkout.php" method="post">
            <button type="submit">Afrekenen</button>
        </form>
    <?php } else { ?>
        <p>Je winkelmand is leeg.</p>
    <?php } ?>
</body>
</html>