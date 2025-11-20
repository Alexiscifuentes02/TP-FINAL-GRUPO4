<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Mpdf\Mpdf;

$mpdf = new Mpdf();
$mpdf->WriteHTML("<h1>PDF DE PRUEBA</h1>");
$mpdf->Output();
