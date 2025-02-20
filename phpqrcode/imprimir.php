<?php
require('fpdf/fpdf.php');
require('phpqrcode/qrlib.php');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "locales_db";

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID del local
    $id = $_GET['id'];

    // Consulta para obtener los datos del local
    $stmt = $conn->prepare("SELECT * FROM locales WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $local = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$local) {
        die('El local no existe.');
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

// Generar QR temporal
$qr_temp = 'temp_qr_' . $local['id'] . '.png';
QRcode::png('http://192.168.0.235/GENERADOR_QR/detalles.php?id=' . $local['id'], $qr_temp, QR_ECLEVEL_L, 4);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();

// Logo
$pdf->Image('img/logo.jpg', 10, 10, 30); // Ajusta la ruta y el tamaño según tu logo
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Cuerpo de Bomberos La Troncal', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de permiso de funcionamiento', 0, 1, 'C');
$pdf->Ln(10);

// Línea separadora
$pdf->SetLineWidth(0.5);
$pdf->Line(10, 45, 200, 45);
$pdf->Ln(10);

// Información del local
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, 'Nombre del Local: ' . $local['nombre_local'], 0, 1, 'L');
$pdf->Cell(0, 8, 'Propietario: ' . $local['nombre_propietario'], 0, 1, 'L');
$pdf->Cell(0, 8, utf8_decode('Cédula: ') . $local['cedula'], 0, 1, 'L');
$pdf->Cell(0, 8, 'Estado del Permiso: ' . $local['estado_permiso'], 0, 1, 'L');
$pdf->Cell(0, 8, utf8_decode ('Permiso Válido Desde: ') . date('d-m-Y H:i:s', strtotime($local['fecha_creacion'])), 0, 1, 'L');
$pdf->Cell(0, 8, utf8_decode ('Permiso Válido Hasta: ' ) . date('d-m-Y', strtotime($local['fecha_creacion'] . ' +1 month')), 0, 1, 'L');

// Línea separadora
$pdf->Ln(5);
$pdf->SetLineWidth(0.2);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(10);

// QR Code
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Codigo QR:', 0, 1, 'L');
$pdf->Image($qr_temp, $pdf->GetX() + 60, $pdf->GetY(), 50, 50); // Centra el QR en la columna
$pdf->Ln(60);

// Eliminar archivo temporal del QR
unlink($qr_temp);

// Salida del PDF
$pdf->Output();
