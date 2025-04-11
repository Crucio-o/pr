<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: authorization.php");
    exit();
}

$email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT first_name, second_name, data_rozd, email, id_pol FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Ошибка: пользователь не найден!";
    exit();
}

$gender = ($user['id_pol'] == 1) ? "Мужской" : "Женский";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style-acc.css">
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
                <li><a href="#" onclick="confirmLogout()">Выход</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
                <a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a>
                <a href="index.php#about">О нас</a>
                <a href="products.php">Товары</a>
                <a href="set_of_products.php">Корзина</a>
                <a href="zakaz.php">Заказы</a>
                <a href="index.php#search">Поиск</a>
                <a href="index.php#contacts">Контакты</a>
                <a href="#" onclick="confirmLogout()">Выход</a>
            </div>
        </nav>
    </header>

    <main class="account-container">
        <h2>Личный кабинет</h2>
        <div class="user-info">
            <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['first_name']); ?></p>
            <p><strong>Фамилия:</strong> <?php echo htmlspecialchars($user['second_name']); ?></p>
            <p><strong>Дата рождения:</strong> <?php echo htmlspecialchars($user['data_rozd']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Пол:</strong> <?php echo $gender; ?></p>
        </div>
    </main>

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

function confirmLogout() {
    if (confirm("Вы действительно хотите выйти из аккаунта?")) {
        window.location.href = "logout.php";
    }
}
    </script>
</body>
</html>
