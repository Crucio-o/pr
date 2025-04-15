<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: registration.php');
        exit();
    }

$product_id = (int)$_POST['product_id'];
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->execute([$user_id, $product_id]);
$existing = $stmt->fetch();

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE id_cart = ?");
        $stmt->execute([$existing['id_cart']]);
    } else {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id_product = ?");
        $stmt->execute([$product_id]);
        $price = $stmt->fetchColumn();
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity, act_price) VALUES (?, ?, 1, ?)");
        $stmt->execute([$user_id, $product_id, $price]);
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($query !== '') {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->execute(["%$query%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}

$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style-prod.css">
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
                <?php if (isset($_SESSION['user_email'])): ?>
                    <li><a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a></li>
                    <li><a href="set_of_products.php">Корзина</a></li>
                    <li><a href="zakaz.php">Заказы</a></li>
                <?php else: ?>
                    <li><a href="index.php">На главную</a></li>
                    <li><a href="registration.php">Регистрация</a></li>
                    <li><a href="index.php#auth">Авторизация</a></li>
                <?php endif; ?>
                <li><a href="index.php#about">О нас</a></li>
                <li><a href="products.php">Товары</a></li>
                <li><a href="index.php#search">Поиск</a></li>
                <li><a href="index.php#contacts">Контакты</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
            <?php if (isset($_SESSION['user_email'])): ?>
                    <a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a>
                    <a href="set_of_products.php">Корзина</a>
                    <a href="zakaz.php">Заказы</a>
                <?php else: ?>
                    <a href="index.php">На главную</a>
                    <a href="registration.php">Регистрация</a>
                    <a href="index.php#auth">Авторизация</a>
                <?php endif; ?>
                <a href="index.php#about">О нас</a>
                <a href="products.php">Товары</a>
                <a href="index.php#search">Поиск</a>
                <a href="index.php#contacts">Контакты</a>
            </div>
        </nav>
    </header>
    <main>
    <h1 id="our-prod">Наши товары</h1>
        <section class="products-section">
            <form method="get" action="products.php" class="search-form">
                <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Поиск по товарам">
                <button type="submit">Поиск</button>
            </form>
            <div class="products-grid">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <p><?= htmlspecialchars($product['description']) ?></p>
                            <p class="price"><?= $product['price'] ?> ₽ / шт</p>
                            <form method="post" class="add-to-cart-form">
                                <input type="hidden" name="product_id" value="<?= $product['id_product'] ?>">
                                <button type="submit">В корзину</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p id="nothing">Ничего не найдено</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer>
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
