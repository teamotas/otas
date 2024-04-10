<?php
// require_once __DIR__ . '/vendor/autoload.php';

// use PhpOffice\PhpWord\PhpWord;
// use PhpOffice\PhpWord\SimpleType\JcTable;

// // Create a new PhpWord instance
// $phpWord = new PhpWord();

// // Add a section to the document
// $section = $phpWord->addSection();

// // Define table styles
// $cellStyle = array(
//     'borderSize' => 6,
//     'borderColor' => '000000',
// );

// $headerCellStyle = array(
//     'bgColor' => 'C0C0C0', // Light grey background color
//     'color' => 'FFFFFF', // White text color
//     'bold' => true, // Bold text
//     'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER // Center alignment
// );

// // Add a table to the section
// $table = $section->addTable();
// $table->addRow();
// for ($i = 0; $i < 8; $i++) {
//     $table->addCell(600, $cellStyle)->addText('Header ' . ($i + 1), $headerCellStyle);
// }
// for ($i = 0; $i < 7; $i++) {
//     $table->addRow();
//     for ($j = 0; $j < 8; $j++) {
//         $table->addCell(600, $cellStyle)->addText('Data ' . ($i + 1) . '-' . ($j + 1));
//     }
// }

// // Save the document
// $filename = 'sample_table.docx';
// $phpWord->save($filename);

// // Download the document
// header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename="' . $filename . '"');
// readfile($filename);

// // Delete the temporary file
// unlink($filename);










require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;

// Create a new PhpWord instance
$phpWord = new PhpWord();

// Add a section to the document
$section = $phpWord->addSection();

// Add a title to the section
$title = $section->addTitle('Sample Word Document');

// Add some text to the section
$section->addText('This is a sample Word document generated using PhpWord.');

// Add a table to the section
$table = $section->addTable();
$table->addRow();
$table->addCell(5000)->addText('Cell 1');
$table->addCell(5000)->addText('Cell 2');

// Save the document
$filename = 'sample_document.docx';
$phpWord->save($filename);

// Download the document
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the temporary file
unlink($filename);
?>
