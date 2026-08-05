<?php
require_once 'conexion.php';

// Ruta absoluta y segura a fpdf.php
require_once __DIR__ . '/fpdf/fpdf.php';   // ← ESTA LÍNEA ES LA CLAVE

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Lista de Usuarios',0,1,'C');
$pdf->Ln(10);

// Encabezados
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,10,'ID',1);
$pdf->Cell(40,10,'Nombres',1);
$pdf->Cell(30,10,'Usuario',1);
$pdf->Cell(40,10,'Telefono',1);
$pdf->Cell(60,10,'Correo',1);
$pdf->Ln();

// Consulta
$sql = "SELECT * FROM usuarios";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mostrar registros
$pdf->SetFont('Arial','',12);
if ($usuarios && count($usuarios) > 0) {
    foreach ($usuarios as $usuario) {
        $pdf->Cell(20,10,$usuario['id'],1);
        $pdf->Cell(40,10,utf8_decode($usuario['nombres']),1);     // ← utf8_decode para ñ y acentos
        $pdf->Cell(30,10,$usuario['usuario'],1);
        $pdf->Cell(40,10,$usuario['telefono'],1);
        $pdf->Cell(60,10,$usuario['correo'],1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190,10,'No se encontraron usuarios',1,1,'C');
}

$pdf->Output('D', 'Lista_de_Usuarios.pdf'); // 'D' = descarga forzada con nombre
?>