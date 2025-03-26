<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cart'], $_POST['action'])) {
    $id_cart = intval($_POST['id_cart']);
    $action = $_POST['action'];
    $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE id_cart = ? AND user_id = ?");
    $stmt->execute([$id_cart, $_SESSION['user_id']]);
    $item = $stmt->fetch();

    if ($item) {
        $quantity = $item['quantity'];

        if ($action === 'increase') {
            $quantity++;
        } elseif ($action === 'decrease' && $quantity > 1) {
            $quantity--;
        }

        $updateStmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id_cart = ?");
        $updateStmt->execute([$quantity, $id_cart]);
    }
}

header("Location: set_of_products.php");
exit();
