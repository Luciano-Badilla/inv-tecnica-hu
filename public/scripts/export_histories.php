<?php
require "../../vendor/autoload.php"; // Ajusta según la ubicación de vendor

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Obtén el título desde la solicitud AJAX
$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';

// Obtén los nombres de las columnas, las columnas seleccionadas y los datos desde la solicitud AJAX
$columnNames = isset($_POST['columnNames']) ? json_decode($_POST['columnNames'], true) : [];
$selectedColumns = isset($_POST['selectedColumns']) ? json_decode($_POST['selectedColumns'], true) : [];
$data = isset($_POST['data']) ? json_decode($_POST['data'], true) : [];

// Verifica si los datos están presentes
if (empty($data)) {
    echo "No data received";
    exit;
}

// Crear una nueva instancia de Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar el título en la primera fila
if (!empty($titulo)) {
    $sheet->setCellValue('A1', $titulo);
    // Establece el formato de la celda del título
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(11);
    // Ajusta el ancho de la columna para el título
    $sheet->getColumnDimension('A')->setAutoSize(true);
    // Deja una fila en blanco antes de los datos
    $rowIndex = 2;
} else {
    $rowIndex = 1;
}

// Agregar los nombres de las columnas en la primera fila
$colIndex = 'A';
foreach ($selectedColumns as $columnIndex) {
    $sheet->setCellValue($colIndex . $rowIndex, $columnNames[$columnIndex]);
    // Aplicar formato en negrita a los nombres de las columnas
    $sheet->getStyle($colIndex . $rowIndex)->getFont()->setBold(true);
    $colIndex++;
}

// Incrementar el índice de fila para los datos
$rowIndex++;

// Escribir los datos en la hoja, solo para las columnas seleccionadas
foreach ($data as $rowData) {
    $colIndex = 'A';
    foreach ($selectedColumns as $columnIndex) {
        // Reemplaza <br> por \n si es necesario
        $cellValue = str_replace('<br>', "\n", $rowData[$columnIndex]);
        $sheet->setCellValue($colIndex . $rowIndex, $cellValue);
        $sheet->getStyle($colIndex . $rowIndex)->getAlignment()->setWrapText(true);
        $colIndex++;
    }
    $rowIndex++;
}

// Ajusta automáticamente el ancho de las columnas
foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Opcional: Ajusta la altura de las filas para asegurar que el texto sea visible
foreach (range(1, $rowIndex - 1) as $row) {
    $sheet->getRowDimension($row)->setRowHeight(-1); // Ajusta automáticamente la altura de la fila
}

// Configura las cabeceras para la descarga del archivo Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $titulo . '.xlsx"');
header('Cache-Control: max-age=0');

// Crear el archivo Excel y enviarlo al navegador
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
