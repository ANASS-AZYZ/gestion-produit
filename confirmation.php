<?php
session_start();
require_once "includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: produits.php");
    exit;
}

$idProduit = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
$stmt->execute([$idProduit]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    header("Location: produits.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        .confirmation-message {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="confirmation-message">
        <h3>Votre commande a été complétée avec succès !</h3>
        <p>Nous vous contacterons bientôt.</p>
    </div>

    <div class="text-center">
        <a href="produits.php" class="btn btn-primary">Retour à la liste des produits</a>
    </div>
</div>
</body>
</html>
