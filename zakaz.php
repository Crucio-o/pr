<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Вы не авторизованы. <a href='login.php'>Войти</a></p>";
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT 
        o.id_order,
        o.created_at,
        s.name AS status_name,
        p.name AS product_name,
        op.quantity,
        op.act_price
    FROM orders o
    JOIN order_prod op ON o.id_order = op.id_order
    JOIN products p ON op.id_product = p.id_product
    JOIN status s ON o.id_status = s.id_status
    WHERE o.id_user = :user_id
    ORDER BY o.created_at DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$orders = [];
foreach ($rows as $row) {
    $id = $row['id_order'];
    if (!isset($orders[$id])) {
        $orders[$id] = [
            'created_at' => $row['created_at'],
            'status' => $row['status_name'],
            'items' => []
        ];
    }
    $orders[$id]['items'][] = [
        'name' => $row['product_name'],
        'quantity' => $row['quantity'],
        'act_price' => $row['act_price']
    ];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style-zak.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Merriweather:wght@300;700&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
        <div class="logo">
            <img src="img/logo.png">
            Pillow & Blanket
        </div>
        <button class="menu-button" onclick="toggleMenu()">☰ Меню</button>
        <nav>
            <ul class="nav-menu">
                <li><a href="index.php">На главную</a></li>
                <li><a href="products.php">Товары</a></li>
                <li><a href="set_of_products.php">Корзина</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
                <a href="index.php">На главную</a>
                <a href="products.php">Товары</a>
                <a href="set_of_products.php">Корзина</a>
            </div>
        </nav>
    </header>

<main>
    <h1>Мои заказы</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="success">Ваш заказ был успешно оформлен!</div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <p style="text-align:center;">У вас ещё нет заказов.</p>
    <?php else: ?>
        <?php foreach ($orders as $id_order => $order): ?>
            <div class="order">
                <h2>Заказ №<?= $id_order ?> — <?= date("d.m.Y H:i", strtotime($order['created_at'])) ?></h2>
                <p><strong>Статус:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <div class="items">
                    <?php foreach ($order['items'] as $item): ?>
                        <div class="item">
                            <div class="item-info">
                                <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div><?= $item['quantity'] ?> × <?= $item['act_price'] ?> ₽</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<footer>
    <div>
        <p>Контактная информация</p>
    </div>
</footer>
<script>
    function toggleMenu() {
            const menu = document.getElementById("menuDropdown");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("menuDropdown").style.display = "none";

    document.addEventListener("click", function(event) {
        const menu = document.getElementById("menuDropdown");
        const button = document.querySelector(".menu-button");

        if (!menu.contains(event.target) && !button.contains(event.target)) {
            menu.style.display = "none";
        }
    });
});
</script>
</body>
</html>
