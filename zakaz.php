<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Вы не авторизованы. <a href='login.php'>Войти</a></p>";
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT c.product_id, c.quantity, c.act_price, p.name, p.image_url
    FROM cart c
    JOIN products p ON c.product_id = p.id_product
    WHERE c.user_id = :user_id
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$orders = $stmt->fetchAll();
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

<h1>Мои заказы</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="success">Ваш заказ был успешно оформлен!</div>
<?php endif; ?>

<?php if (count($orders) === 0): ?>
    <p style="text-align:center;">У вас ещё нет заказов.</p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <div class="order">
            <h2>Заказ №<?= $order['product_id'] ?> — <?= date("d.m.Y H:i") ?></h2>
            <div><strong>Товары:</strong></div>

            <div class="item">
                <?= htmlspecialchars($order['name']) ?> — <?= $order['quantity'] ?> шт. по <?= $order['act_price'] ?> ₽
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
