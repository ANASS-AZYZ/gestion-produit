<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contactez-nous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .contact-info {
            margin-top: 20px;
        }
        .contact-info h4 {
            margin-bottom: 10px;
            color: #0dcaf0;
        }
        .social-icons a {
            margin: 0 15px;
            font-size: 2rem;
            color: #0dcaf0;
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
                    <a class="nav-link text-info" href="produits.php">Maison</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="#">Catégories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="contact.php">Contactez-nous</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center text-info mb-4">Contactez-nous</h2>

    <div class="contact-info text-center">
        <h4>Email :</h4>
        <p><a href="mailto:anass.azyz.06@gmail.com">anass.azyz.06@gmail.com</a></p>

        <h4>Téléphone :</h4>
        <p><a href="tel:+212600371408">+212 600 371 408</a></p>

        <h4>Réseaux sociaux :</h4>
        <div class="social-icons">
            <a href="https://linkedin.com/in/anass-azyz-404a25342" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.instagram.com/anass___azyz?igsh=MXgwcHI3dHdoZHBrNQ%3D%3D&utm_source=qr" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/share/16cXpJN365/?mibextid=wwXIfr" target="_blank"><i class="fab fa-facebook"></i></a>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="produits.php" class="btn btn-outline-info">⬅ Retour à la liste des produits</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
