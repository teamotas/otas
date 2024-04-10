<?php

// Include the Composer autoload file to load dependencies
require 'vendor/autoload.php';

use Mpdf\Mpdf;

// Create a new instance of mPDF
$mpdf = new Mpdf();

// Add content to the PDF (e.g., HTML content)
$html = '<h1>Hello, World!</h1><p>This is a sample PDF generated using mPDF library.</p>';
$mpdf->WriteHTML($html);

// Set PDF metadata (optional)
$mpdf->SetTitle('Sample PDF');
$mpdf->SetAuthor('Your Name');
$mpdf->SetSubject('Sample PDF Document');
$mpdf->SetKeywords('PDF, mPDF, PHP');

// Output the PDF as a file
$mpdf->Output('example.pdf', 'F');

echo 'PDF file generated successfully.';

