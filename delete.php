<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cart'])) {
    $id_cart = intval($_POST['id_cart']);

    $stmt = $pdo->prepare("DELETE FROM cart WHERE id_cart = ? AND user_id = ?");
    $stmt->execute([$id_cart, $_SESSION['user_id']]);
}

header("Location: set_of_products.php");
exit();
