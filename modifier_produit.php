<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Produit non trouvé.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    die("Produit non trouvé.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE produit SET nom = ?, categorie = ?, prix = ?, quantite = ?, description = ? WHERE id = ?");
    $stmt->execute([$nom, $categorie, $prix, $quantite, $description, $id]);

    header("Location: produits.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier le produit</h2>

    <form method="POST" action="modifier_produit.php?id=<?= $produit['id'] ?>">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($produit['nom']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <input type="text" name="categorie" id="categorie" class="form-control" value="<?= htmlspecialchars($produit['categorie']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" step="0.01" name="prix" id="prix" class="form-control" value="<?= htmlspecialchars($produit['prix']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" name="quantite" id="quantite" class="form-control" value="<?= htmlspecialchars($produit['quantite']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($produit['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Enregistrer
        </button>
        <a href="produit.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
