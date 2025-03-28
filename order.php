<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT * FROM cart WHERE user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll();

if (count($cartItems) === 0) {
    header("Location: set_of_products.php");
    exit();
}

try {
    $pdo->beginTransaction();

    $insertOrder = $pdo->prepare("
        INSERT INTO orders (id_user, id_status) VALUES (?, 1)
    ");
    $insertOrder->execute([$user_id]);
    $order_id = $pdo->lastInsertId();

    $insertItem = $pdo->prepare("
        INSERT INTO order_prod (id_order, id_product, quantity, act_price) 
        VALUES (?, ?, ?, ?)
    ");
    $updateStock = $pdo->prepare("
        UPDATE products SET kol_vo = kol_vo - ? WHERE id_product = ?
    ");

    foreach ($cartItems as $item) {
        $insertItem->execute([
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['act_price']
        ]);

        $updateStock->execute([
            $item['quantity'],
            $item['product_id']
        ]);
    }

    $clearCart = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $clearCart->execute([$user_id]);

    $pdo->commit();

    header("Location: zakaz.php?success=1");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Ошибка оформления заказа: " . $e->getMessage();
}
