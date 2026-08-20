<?php
// libs/exporteurs.php - Export Excel (SpreadsheetML) et PDF (FPDF)

require_once __DIR__ . '/fpdf/fpdf.php';

function nom_fichier($titre) {
    $nom = strtolower(trim($titre));
    $nom = preg_replace('/[^a-z0-9]+/', '_', $nom);
    return $nom ?: 'rapport';
}

function exportExcel($titre, $colonnes, $lignes) {
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . nom_fichier($titre) . '.xls"');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';
    echo '<Worksheet ss:Name="Rapport"><Table>';
    echo '<Row>';
    foreach ($colonnes as $c) {
        echo '<Cell><Data ss:Type="String">' . h($c) . '</Data></Cell>';
    }
    echo '</Row>';
    foreach ($lignes as $l) {
        echo '<Row>';
        foreach ($l as $v) {
            $numerique = is_numeric($v);
            echo '<Cell><Data ss:Type="' . ($numerique ? 'Number' : 'String') . '">'
                . ($numerique ? (string)round((float)$v, 2) : h((string)$v)) . '</Data></Cell>';
        }
        echo '</Row>';
    }
    echo '</Table></Worksheet></Workbook>';
    exit;
}

class RapportPDF extends FPDF {

    public function entete($titre) {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, mb_convert_encoding(APP_NAME, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(60, 60, 60);
        $this->Cell(0, 8, mb_convert_encoding($titre, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->Ln(4);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, mb_convert_encoding('Généré le ' . date('d/m/Y H:i') . " - Page " . $this->PageNo() . '/{nb}', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    }
}

function exportPDF($titre, $colonnes, $lignes) {
    $pdf = new RapportPDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();
    $pdf->entete($titre);

    $nb_colonnes = count($colonnes);
    $largeur = 190 / max($nb_colonnes, 1);

    $pdf->SetFillColor(30, 58, 95);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 9);
    foreach ($colonnes as $c) {
        $pdf->Cell($largeur, 8, mb_convert_encoding($c, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
    }
    $pdf->Ln();

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $alterner = false;
    foreach ($lignes as $l) {
        $pdf->SetFillColor($alterner ? 245 : 255, $alterner ? 248 : 255, $alterner ? 251 : 255);
        foreach ($l as $v) {
            $texte = is_numeric($v) ? number_format((float)$v, 0, ',', ' ') : (string)$v;
            $pdf->Cell($largeur, 7, mb_convert_encoding($texte, 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
        }
        $pdf->Ln();
        $alterner = !$alterner;
    }

    $pdf->Output('D', nom_fichier($titre) . '.pdf');
    exit;
}