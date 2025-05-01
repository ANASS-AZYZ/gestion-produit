<?php
require_once('vendor/autoload.php');

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$pdf->Cell(0, 10, 'Liste des Produits', 0, 1, 'C');

$pdf->Ln(10);

$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(20, 10, 'ID', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Nom', 1, 0, 'C', 1);
$pdf->Cell(40, 10, 'Catégorie', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Prix (DH)', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Stock', 1, 0, 'C', 1);
$pdf->Cell(50, 10, 'Description', 1, 1, 'C', 1);

require_once "includes/db.php";

$stmt = $pdo->query("SELECT * FROM produits ORDER BY id DESC");
$produits = $stmt->fetchAll();

foreach ($produits as $produit) {
    $pdf->Cell(20, 10, $produit['id'], 1, 0, 'C');
    $pdf->Cell(50, 10, htmlspecialchars($produit['nom']), 1, 0, 'C');
    $pdf->Cell(40, 10, htmlspecialchars($produit['categorie']), 1, 0, 'C');
    $pdf->Cell(30, 10, number_format($produit['prix'], 2) . ' DH', 1, 0, 'C');
    $pdf->Cell(30, 10, $produit['stock'], 1, 0, 'C');
    $pdf->Cell(50, 10, htmlspecialchars($produit['description']), 1, 1, 'C');
}

$pdf->Output('produits.pdf', 'I');
?>
