<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

// Create a new PhpWord instance
$phpWord = new PhpWord();

// Add a section to the document
// $section = $phpWord->addSection();
$section = $phpWord->addSection(['orientation' => 'landscape']);


// Define the title text with HTML line break tags
$titleText = 'SECTION-I<br>ONLINE TESTING AND ASSESSMENT SERVICES<br>STATUS OF BUSINESS DEVELOPMENT & DELIVERY REPORT<br>PROJECTS COMPLETED FROM 1ST JANUARY to 31ST MARCH 2024<br>(CURRENT ASSIGNMENTS EXAM CONDUCTED FROM JANUARY to MARCH 2024)';

// Add the title to the section with specified depth (1)
$title = $section->addTitle($titleText, 1);

// Set the alignment of the title to center
// $title->getAlignment()->setHorizontal(Jc::CENTER);

// Add more content to the document if needed...

// Save the document
$filename = 'your_document.docx';
$phpWord->save($filename);

// Download the document
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the temporary file
unlink($filename);
?>
