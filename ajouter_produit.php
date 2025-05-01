<?php
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST['nom'];
    $categorie = $_POST['categorie'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $description = $_POST['description'];
    
    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = 'uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    $stmt = $pdo->prepare("INSERT INTO produit (nom, categorie, prix, quantite, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $categorie, $prix, $quantite, $description, $imageName]);

    header("Location: produits.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Ajouter un nouveau produit</h2>

    <a href="produits.php" class="btn btn-secondary mb-3">
        <i class="fas fa-list"></i> Liste des Produits
    </a>

    <form method="post" enctype="multipart/form-data" class="border p-4 rounded shadow-sm bg-light">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" class="form-control" name="nom" required>
        </div>

        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <select class="form-select" name="categorie" required>
                <option value="">-- Sélectionnez une catégorie --</option>
                <option value="ordinateur">Ordinateur</option>
                <option value="telephone mobile">Téléphone Mobile</option>
                <option value="switch">Switch</option>
                <option value="accessoire">Accessoire</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix (MAD)</label>
            <input type="number" step="0.01" class="form-control" name="prix" required>
        </div>

        <div class="mb-3">
            <label for="quantite" class="form-label">Quantité</label>
            <input type="number" class="form-control" name="quantite" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image du produit</label>
            <input type="file" class="form-control" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Enregistrer
        </button>
    </form>
</div>
</body>
</html>
