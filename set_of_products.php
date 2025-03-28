<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT c.id_cart, c.quantity, c.act_price, 
           p.name, p.image_url, p.price
    FROM cart c
    JOIN products p ON c.product_id = p.id_product
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll();

$total = 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style-set.css">
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
            <?php if (isset($_SESSION['user_email'])): ?>
                    <li><a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a></li>
                <?php else: ?>
                    <li><a href="registration.php">Регистрация</a></li>
                <?php endif; ?>
                <li><a href="products.php">Товары</a></li>
                <li><a href="set_of_products.php">Корзина</a></li>
                <li><a href="zakaz.php">Заказы</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
            <?php if (isset($_SESSION['user_email'])): ?>
                    <a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a>
                <?php else: ?>
                    <a href="registration.php">Регистрация</a>
                <?php endif; ?>
                <a href="products.php">Товары</a>
                <a href="set_of_products.php">Корзина</a>
                <a href="zakaz.php">Заказы</a>
            </div>
        </nav>
    </header>
    <div class="main-content">
    <h1>Моя корзина</h1>
    <?php if (count($cartItems) > 0): ?>
        <?php foreach ($cartItems as $row): 
    $item_total = $row['act_price'] * $row['quantity'];
    $total += $item_total;
?>
    <div class="cart-item">
        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <div class="item-info">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
            <p>Цена за шт: <?= $row['act_price'] ?>₽</p>

            <form action="update.php" method="post" class="quantity-form">
                <input type="hidden" name="id_cart" value="<?= $row['id_cart'] ?>">
                <button type="submit" name="action" value="decrease">−</button>
                <span><?= $row['quantity'] ?></span>
                <button type="submit" name="action" value="increase">+</button>
            </form>

            <p>Сумма: <?= $item_total ?>₽</p>

            <form action="delete.php" method="post" class="delete-form">
                <input type="hidden" name="id_cart" value="<?= $row['id_cart'] ?>">
                <button type="submit" onclick="return confirm('Удалить этот товар из корзины?')">Удалить</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<div class="total-order-container">
    <div class="total">Общая сумма: <?= $total ?>₽</div>
    <form action="order.php" method="post" class="order-form">
        <button type="submit">Заказать всё</button>
    </form>
</div>
    <?php else: ?>
        <p>Ваша корзина пуста.</p>
    <?php endif; ?>
    </div>
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
