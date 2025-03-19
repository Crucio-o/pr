<?php
require 'db.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $birthDate = $_POST['birthDate'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($email) || empty($firstName) || empty($lastName) || empty($birthDate) || empty($gender) || empty($password) || empty($confirmPassword)) {
        echo json_encode(["status" => "error", "message" => "Заполните все поля!"]);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => "Пароли не совпадают!"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        echo json_encode(["status" => "error", "message" => "Этот e-mail уже зарегистрирован!"]);
        exit;
    }

    $genderId = ($gender == "male") ? 1 : 2;

    $stmt = $pdo->prepare("INSERT INTO users (first_name, second_name, id_pol, data_rozd, email, password, id_role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([$firstName, $lastName, $genderId, $birthDate, $email, $password, 1]);

    if ($result) {
        header("Location: index.php?success=1");
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Произошла ошибка при регистрации!"]);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="styles/style-reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Merriweather:wght@300;700&family=Poppins:wght@300;600&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="logo">
        <img src="img/logo.png" alt="Logo">
        Pillow & Blanket
    </div>
    <nav>
        <ul class="nav-menu">
            <li><a href="index.php">Назад</a></li>
        </ul>
    </nav>
</header>
<div class="container">
    <h2>Регистрация</h2>
    <form id="registrationForm" method="POST">
        <input type="email" id="email" name="email" placeholder="E-mail" required>
        <span class="error" id="emailError"></span>

        <input type="text" id="firstName" name="firstName" placeholder="Имя" required>
        <span class="error" id="firstNameError"></span>

        <input type="text" id="lastName" name="lastName" placeholder="Фамилия" required>
        <span class="error" id="lastNameError"></span>

        <input type="date" id="birthDate" name="birthDate" required>
        <span class="error" id="birthDateError"></span>

        <select id="gender" name="gender" required>
            <option value="">Выберите пол</option>
            <option value="male">Мужской</option>
            <option value="female">Женский</option>
        </select>
        <span class="error" id="genderError"></span>

        <input type="password" id="password" name="password" placeholder="Пароль" required>
        <span class="error" id="passwordError"></span>

        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Повтор пароля" required>
        <span class="error" id="confirmPasswordError"></span>

        <label>
            <input type="checkbox" id="terms" name="terms" required> Я согласен на обработку персональных данных
        </label>
        <span class="error" id="termsError"></span>

        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
</body>
</html>
