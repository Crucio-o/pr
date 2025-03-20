<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $user['password'] == $password) {
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_id'] = $user['id_user'];

        header('Location: index.php'); 
        exit();
    } else {
        echo 'Неверный логин или пароль.';
    }
}
?>
