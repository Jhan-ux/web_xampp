<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

function limpiar(?string $texto): string
{
    // FPDF (core, sin UTF-8) espera ISO-8859-1
    return mb_convert_encoding((string)$texto, 'ISO-8859-1', 'UTF-8');
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Lista de Usuarios', 0, 1, 'C');
$pdf->Ln(10);

// Encabezados
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Nombres', 1);
$pdf->Cell(30, 10, 'Usuario', 1);
$pdf->Cell(40, 10, 'Telefono', 1);
$pdf->Cell(60, 10, 'Correo', 1);
$pdf->Ln();

$stmt = $conexion->query("SELECT id, nombres, usuario, telefono, correo FROM usuarios ORDER BY id");
$usuarios = $stmt->fetchAll();

$pdf->SetFont('Arial', '', 12);
if ($usuarios && count($usuarios) > 0) {
    foreach ($usuarios as $usuario) {
        $pdf->Cell(20, 10, (string)$usuario['id'], 1);
        $pdf->Cell(40, 10, limpiar($usuario['nombres']), 1);
        $pdf->Cell(30, 10, limpiar($usuario['usuario']), 1);
        $pdf->Cell(40, 10, limpiar($usuario['telefono']), 1);
        $pdf->Cell(60, 10, limpiar($usuario['correo']), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'No se encontraron usuarios', 1, 1, 'C');
}

$pdf->Output('D', 'Lista_de_Usuarios.pdf');
