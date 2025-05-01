<?php
session_start();
require_once "includes/db.php";

// Vérification si un produit est sélectionné
if (!isset($_GET['id'])) {
    header("Location: produits.php");
    exit;
}

$idProduit = $_GET['id'];

// Récupérer les informations du produit
$stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
$stmt->execute([$idProduit]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    header("Location: produits.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sauvegarder les informations de l'utilisateur
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];

    // Ajouter la commande à la base de données
    $stmt = $pdo->prepare("INSERT INTO commandes (produit_id, nom, prenom, telephone) VALUES (?, ?, ?, ?)");
    $stmt->execute([$idProduit, $nom, $prenom, $telephone]);

    // Rediriger vers la page de confirmation
    header("Location: confirmation.php?id=$idProduit");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Achat produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center text-info mb-4">Détails de l'achat</h2>

    <div class="card mb-4">
        <img src="uploads/<?= htmlspecialchars($produit['image']) ?>" class="card-img-top" alt="Image du produit">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($produit['description']) ?></p>
            <p class="card-text"><strong><?= htmlspecialchars($produit['prix']) ?> MAD</strong></p>
        </div>
    </div>

    <h4>Veuillez entrer vos informations :</h4>
    <form action="acheter.php?id=<?= $idProduit ?>" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Numéro de téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" required>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>
</body>
</html>
