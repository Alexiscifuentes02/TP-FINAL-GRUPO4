<?php
// Limpiar buffers para evitar PDF corrupto
if (ob_get_length()) ob_end_clean();
ob_start();

require_once __DIR__ . '/../vendor/autoload.php';
use Mpdf\Mpdf;

if (!isset($_POST["html"])) {
    exit("No HTML recibido");
}

$html = $_POST["html"];

// Crear PDF
$mpdf = new Mpdf();
$mpdf->WriteHTML($html);

// Limpiar buffer final
ob_end_clean();

// Descargar PDF
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=comprobante_compra.pdf");
echo $mpdf->Output('', 'S');
exit;
