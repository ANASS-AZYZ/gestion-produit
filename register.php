<?php
session_start();
require_once "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $error = "Ce email est déjà utilisé.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $password_hashed]);

            $_SESSION['user'] = $email;
            header("Location: produits.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Créer un compte</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <p class="mt-3">Vous avez déjà un compte? <a href="login.php">Se connecter</a></p>
</div>
</body>
</html>
