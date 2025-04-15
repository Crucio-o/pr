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
    <title>Корзина</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style-set.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Merriweather:wght@300;700&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
    <header>
        <div class="logo">
            <a href="index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                <img src="img/logo.png">
                Pillow & Blanket
            </a>
        </div>
        <button class="menu-button" onclick="toggleMenu()">☰ Меню</button>
        <nav>
            <ul class="nav-menu">
                <li><a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a></li>
                <li><a href="set_of_products.php">Корзина</a></li>
                <li><a href="zakaz.php">Заказы</a></li>
                <li><a href="index.php#about">О нас</a></li>
                <li><a href="products.php">Товары</a></li>
                <li><a href="index.php#search">Поиск</a></li>
                <li><a href="index.php#contacts">Контакты</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
                <a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a>
                <a href="index.php#about">О нас</a>
                <a href="products.php">Товары</a>
                <a href="set_of_products.php">Корзина</a>
                <a href="zakaz.php">Заказы</a>
                <a href="index.php#search">Поиск</a>
                <a href="index.php#contacts">Контакты</a>
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
                <p>Сумма: <?= $item_total ?>₽</p>
            </div>

            <div class="item-actions">
                <form action="update.php" method="post" class="quantity-form">
                    <input type="hidden" name="id_cart" value="<?= $row['id_cart'] ?>">
                    <button type="submit" name="action" value="decrease">−</button>
                    <span><?= $row['quantity'] ?></span>
                    <button type="submit" name="action" value="increase">+</button>
                </form>

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
                    <button type="submit" onclick="return confirm('Совершить заказ?')">Заказать всё</button>
                </form>
            </div>
            <?php else: ?>
                <p id="my-set">Ваша корзина пуста.</p>
            <?php endif; ?>
    </div>
    <footer id="contacts">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="img/logo_negate.png" alt="Pillow & Blanket">
                <span class="company-name">Pillow & Blanket</span>
            </div>
            <div class="footer-contacts">
                <div class="contact-item">
                    <span class="label">Адрес</span>
                    <span class="value">Ярославль, ул. Бабича 10/22</span>
                </div>
                <div class="contact-item">
                    <span class="label">Email</span>
                    <a href="" class="value">pillowblanket@gmail.com</a>
                </div>
                <div class="contact-item">
                    <span class="label">Телефон</span>
                    <a href="" class="value">+7 (900) 123-45-67</a>
                </div>
            </div>
        </div>
    </footer>
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
