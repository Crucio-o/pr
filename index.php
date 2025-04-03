<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pillow & Blanket</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style.css">
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
                    <li><a href="set_of_products.php">Корзина</a></li>
                    <li><a href="zakaz.php">Заказы</a></li>
                <?php else: ?>
                    <li><a href="registration.php">Регистрация</a></li>
                    <li><a href="#auth">Авторизация</a></li>
                <?php endif; ?>
                <li><a href="#about">О нас</a></li>
                <li><a href="products.php">Товары</a></li>
                <li><a href="#search">Поиск</a></li>
                <li><a href="#contacts">Контакты</a></li>
            </ul>
            <div class="menu-dropdown" id="menuDropdown">
                <?php if (isset($_SESSION['user_email'])): ?>
                    <a href="account.php">Личный кабинет (<?php echo $_SESSION['user_email']; ?>)</a>
                <?php else: ?>
                    <a href="registration.php">Регистрация</a>
                    <a href="#auth">Авторизация</a>
                <?php endif; ?>
                <a href="#about">О нас</a>
                <a href="products.php">Товары</a>
                <a href="set_of_products.php">Корзина</a>
                <a href="zakaz.php">Заказы</a>
                <a href="#search">Поиск</a>
                <a href="#contacts">Контакты</a>
            </div>
        </nav>
    </header>
    <section id="popular-products" class="slider">
        <div class="slider-container">
            <?php
                $stmt = $pdo->query("SELECT * FROM products LIMIT 5");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="slide">
                            <img src="'.$row['image_url'].'" alt="'.$row['name'].'">
                            <div class="slide-content">
                                <h3>'.$row['name'].'</h3>
                                <p>'.$row['description'].'</p>
                                <button>Подробнее</button>
                            </div>
                        </div>';
                }
            ?>
        </div>
        <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
        <button class="next" onclick="moveSlide(1)">&#10095;</button>
    </section>
    <?php if (isset($_SESSION['user_email'])): ?>
    <?php else: ?>
    <section id="auth">
        <div class="auth-container">
            <h2>Авторизация</h2>
            <form action="authorization.php" method="POST">
                <input type="email" name="email" placeholder="Введите ваш Email" required>
                <input type="password" name="password" placeholder="Введите пароль" required>
                <button type="submit">Войти</button>
            </form>
        </div>
    </section>
    <?php endif; ?>
    <section id="about" class="about-section">
        <div class="about-container">
            <h2>О компании Pillow & Blanket</h2>
            <p>
                Мы — интернет-магазин, специализирующийся на продаже качественного постельного белья.
                Наша цель — обеспечить вас уютом, комфортом и сладкими снами. 
                Мы предлагаем широкий ассортимент товаров из натуральных материалов, следим за модными тенденциями и заботимся о вашем здоровье.
            </p>
            <p>
                Заказывая у нас, вы получаете быструю доставку, приятные цены и гарантированное качество.
                Pillow & Blanket — уют начинается с мелочей.
            </p>
        </div>
    </section>
    <section class="info-sections">
        <div class="info-block left-text">
            <div class="text">
                <h2>Наш подход</h2>
                <p>Мы тщательно подбираем материалы, чтобы ваше постельное бельё было не только красивым, но и максимально комфортным и гипоаллергенным.</p>
            </div>
            <div class="image">
                <img src="img/first.jpg" alt="Комфорт и качество">
            </div>
        </div>

        <div class="info-block right-text">
            <div class="image">
                <img src="img/second.jpg" alt="Дизайн и уют">
            </div>
            <div class="text">
                <h2>Дизайн и уют</h2>
                <p>Мы следим за последними трендами, чтобы создать атмосферу уюта в вашем доме с помощью стильных и функциональных комплектов.</p>
            </div>
        </div>
    </section>
    <form action="products.php" method="GET" class="search-form">
    <input type="text" name="q" placeholder="Введите название товара..." required>
    <button type="submit">Поиск</button>
</form>
    <section id="reviews" class="reviews-section">
    <h2>Отзывы клиентов</h2>
    <div class="reviews-slider">
        <div class="review-slide">
            <img src="img/icon.png">
            <div class="review-content">
                <h3>Иван Иванов</h3>
                <p class="review-text">Прекрасное качество белья! Буду заказывать ещё.</p>
                <p class="review-date">15 марта 2025</p>
                <a href="" class="review-link">Посмотреть товар</a>
            </div>
        </div>
        <div class="review-slide">
        <img src="img/icon.png">
            <div class="review-content">
                <h3>Сергей Смирнов</h3>
                <p class="review-text">Доставили быстро, всё как на фото. Очень доволен покупкой.</p>
                <p class="review-date">27 января 2025</p>
                <a href="" class="review-link">Посмотреть товар</a>
            </div>
        </div>
        <div class="review-slide">
        <img src="img/icon.png">
            <div class="review-content">
                <h3>Ирина Кузнецова</h3>
                <p class="review-text">Цвета невероятные, ткань приятная. Спасибо за уют!</p>
                <p class="review-date">1 февраля 2025</p>
                <a href="" class="review-link">Посмотреть товар</a>
            </div>
        </div>
        <div class="review-slide">
        <img src="img/icon.png">
            <div class="review-content">
                <h3>Максим </h3>
                <p class="review-text">Цвета невероятные, ткань приятная. Спасибо за уют!</p>
                <p class="review-date">10 февраля 2025</p>
                <a href="" class="review-link">Посмотреть товар</a>
            </div>
        </div>
    </div>
</section>

<footer>
    <div id="contacts">
        <p>Контактная информация</p>
    </div>
</footer>

    <script>
        let currentSlide = 0;

        function moveSlide(direction) {
            const slides = document.querySelectorAll('.slide');
            const totalSlides = slides.length;

            currentSlide += direction;

            if (currentSlide < 0) {
                currentSlide = totalSlides - 1;
            } else if (currentSlide >= totalSlides) {
                currentSlide = 0;
            }

            updateSlidePosition();
        }

        function updateSlidePosition() {
            const slidesContainer = document.querySelector('.slider-container');
            const slides = document.querySelectorAll('.slide');
            
            if (slides.length > 0) {
                const slideWidth = slides[0].offsetWidth;
                slidesContainer.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
            }
        }

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
