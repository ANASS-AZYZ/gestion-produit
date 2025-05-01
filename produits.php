<?php 
session_start();
require_once "includes/db.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$searchQuery = '';
$categorieFilter = '';
$titreSection = "Liste des produits";

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $titreSection = "Résultats de recherche pour : \"$searchQuery\"";
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE nom LIKE :search ORDER BY id DESC");
    $stmt->execute(['search' => '%' . $searchQuery . '%']);
} elseif (isset($_GET['categorie'])) {
    $categorieFilter = $_GET['categorie'];
    $titreSection = "Produits dans la catégorie : " . htmlspecialchars(ucfirst($categorieFilter));
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE categorie = :categorie ORDER BY id DESC");
    $stmt->execute(['categorie' => $categorieFilter]);
} else {
    $stmt = $pdo->query("SELECT * FROM produit ORDER BY id DESC");
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmtDelete = $pdo->prepare("DELETE FROM produit WHERE id = ?");
    $stmtDelete->execute([$id]);
    header("Location: produits.php");
    exit;
}

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .product-card {
            transition: 0.3s;
        }
        .product-card:hover {
            transform: scale(1.03);
        }
        .btn-add {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }
        .search-form {
            display: none;
            position: absolute;
            top: 50px;
            right: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-info px-4 py-3">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
            <ul class="navbar-nav mb-2 mb-lg-0 text-center">
                <li class="nav-item">
                    <a class="nav-link text-info" href="#">Maison</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-info" href="#" id="categorieDropdown" role="button" data-bs-toggle="dropdown">
                        Catégories
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="categorieDropdown">
                        <li><a class="dropdown-item" href="produits.php?categorie=ordinateur">Ordinateur</a></li>
                        <li><a class="dropdown-item" href="produits.php?categorie=telephone mobile">Téléphone Mobile</a></li>
                        <li><a class="dropdown-item" href="produits.php?categorie=switch">Switch</a></li>
                        <li><a class="dropdown-item" href="produits.php?categorie=accessoire">Accessoire</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="contact.php">Contactez-nous</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="javascript:void(0);" class="text-info fs-5" onclick="toggleSearch()"><i class="fas fa-search"></i></a>
        </div>
    </div>
</nav>

<a href="ajouter_produit.php" class="btn btn-success btn-add rounded-circle shadow">
    <i class="fas fa-plus"></i>
</a>

<div class="search-form">
    <form action="produits.php" method="get">
        <input type="text" name="search" placeholder="Recherchez un produit" value="<?= htmlspecialchars($searchQuery) ?>" class="form-control">
        <button type="submit" class="btn btn-info mt-2">Rechercher</button>
    </form>
</div>

<div class="container mt-5">
    <h2 class="text-center text-info mb-4"><?= $titreSection ?></h2>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($produits as $produit): ?>
            <div class="col">
                <div class="card product-card shadow-sm h-100">
                    <?php if (!empty($produit['image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($produit['image']) ?>" class="card-img-top" alt="Image du produit">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/300x200?text=No+Image" class="card-img-top" alt="Aucune image">
                    <?php endif; ?>

                    <div class="card-body text-center">
                        <h6 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h6>
                        <p class="mb-1">
                            <?php if (!empty($produit['prix_ancien'])): ?>
                                <span class="text-danger text-decoration-line-through"><?= htmlspecialchars($produit['prix_ancien']) ?> MAD</span>
                            <?php endif; ?>
                            <span class="fw-bold text-primary"><?= htmlspecialchars($produit['prix']) ?> MAD</span>
                        </p>
                        <a href="acheter.php?id=<?= $produit['id'] ?>" class="btn btn-outline-info btn-sm">Acheter maintenant</a>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="modifier_produit.php?id=<?= $produit['id'] ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="produits.php?delete_id=<?= $produit['id'] ?>" onclick="return confirm('Voulez-vous supprimer ce produit ?');" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSearch() {
        const searchForm = document.querySelector('.search-form');
        searchForm.style.display = (searchForm.style.display === 'none' || searchForm.style.display === '') ? 'block' : 'none';
    }
</script>

</body>
</html>
