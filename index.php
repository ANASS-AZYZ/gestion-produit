<?php
session_start();


require_once "includes/db.php";

if (isset($_SESSION['user'])) {
    header("Location: produits.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            header("Location: produits.php");
            exit;
        } else {
            $error = "Le mot de passe est incorrect.";
        }
    } else {
        $error = "Il n'y a aucun utilisateur avec cette adresse e-mail.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f9fc;
            font-family: 'Tajawal', sans-serif;
        }
        .login-box {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.05);
        }
        .login-title {
            color: #00bcd4;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #00bcd4;
            border: none;
        }
        .btn-login:hover {
            background-color: #009eb3;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2 class="login-title">Se connecter</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="email" class="form-label">e-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
        </div>
        <button type="submit" class="btn btn-login w-100 text-white">entrée</button>
    </form>

    <p class="text-center mt-3">
        ليس لديك حساب؟ <a href="register.php" style="color:#00bcd4;">Créer un compte</a>
    </p>
</div>

</body>
</html>
