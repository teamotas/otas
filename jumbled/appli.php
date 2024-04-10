<?php
require_once __DIR__ . '/vendor/autoload.php';

// Create new PDF document
$mpdf = new \Mpdf\Mpdf();

// Application Status data
$data = array(
    'Application Status' => 'Submitted with Fees Exemption',
    'Application Number' => 'NBCC24000151',
    'Candidate\'s Name' => 'NITISH KUMAR',
    'Date of Birth' => '07/May/1977',
    'Age as on 07.05.2024' => '47 Years 0 Months 0 Days',
    'Gender' => 'Male',
    'Marital Status' => 'Married',
    'Religion' => 'Hindu',
    'Father\'s Name' => 'B',
    'Mother\'s Name' => 'B',
    'Email ID' => 'nitishkeshari92@gmail.com',
    'Mobile Number' => '6203323089',
    // Add more data here...
);

// Divide data into chunks of three items each
$chunks = array_chunk($data, 3, true);

// Add HTML content to PDF
$html = '<h1 style="text-align: center;">Application Status</h1>';
foreach ($chunks as $chunk) {
    $html .= '<div style="display: flex; justify-content: space-between; padding: 5px;">';
    foreach ($chunk as $title => $value) {
        $html .= '<div style="flex-basis: 30%;">';
        $html .= '<p><strong>' . $title . ':</strong> ' . $value . '</p>';
        $html .= '</div>';
    }
    $html .= '</div>';
}

// Write HTML content to PDF
$mpdf->WriteHTML($html);

// Output PDF
$mpdf->Output('application_status.pdf', \Mpdf\Output\Destination::DOWNLOAD);
?>
