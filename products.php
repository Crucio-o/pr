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
$stmt = $pdo->query("SELECT * FROM products");
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
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Playfair+Display&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
                    <li><a href="logout.php">Выход</a></li>
                <?php else: ?>
                    <li><a href="registration.php">Регистрация</a></li>
                <?php endif; ?>
                <li><a href="index.php">На главную</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
                <?php if (isset($_SESSION['user_email'])): ?>
                    <a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a>
                    <a href="logout.php">Выход</a>
                <?php else: ?>
                    <a href="registration.php">Регистрация</a>
                <?php endif; ?>
                <a href="index.php">На главную</a>
            </div>
        </nav>
    </header>

<section class="products-section">
    <h2>Наши товары</h2>
    <div class="products-grid">
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
    </div>
</section>
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
