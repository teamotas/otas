<?php

// // Include the Composer autoload file to load dependencies
// require 'vendor/autoload.php';

// use Mpdf\Mpdf;

// // Create a new instance of mPDF
// $mpdf = new Mpdf();

// // Add content to the PDF (e.g., HTML content)
// $html = '<h1>Hello, World!</h1><p>This is a sample PDF generated using mPDF library.</p>';
// $mpdf->WriteHTML($html);

// // Set PDF metadata (optional)
// $mpdf->SetTitle('Sample PDF');
// $mpdf->SetAuthor('Your Name');
// $mpdf->SetSubject('Sample PDF Document');
// $mpdf->SetKeywords('PDF, mPDF, PHP');

// // Output the PDF as a file
// $mpdf->Output('sample.pdf', 'F');

// echo 'PDF file generated successfully.';


















include "connection.php";
include "js/format.php";
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

// Start session
session_start();
$sql = "SELECT *
    FROM tcsprojectdata prdata
    JOIN otasprcandcount count ON prdata.projid = count.projid
    JOIN tcscbtdata cbt ON count.projid=cbt.projid
    JOIN tcsresultdata res ON cbt.projid=res.projid
    JOIN client cl ON prdata.ClientId = cl.ClientId
    LEFT JOIN userotasproject up ON prdata.projid = up.projid
    LEFT JOIN employee em ON up.EmployeeId = em.EmployeeId
    ORDER BY `prdata`.`projid` ASC"; 
    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);
// Create a new instance of mPDF
$mpdf = new Mpdf();

// Set default header and footer
$mpdf->SetHeader('Project Data TCS');
$mpdf->SetFooter('Generated on {DATE}');

// Set content for the PDF
$html = '
    <h1>Project Data TCS</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Sr. No.</th>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Work Order Date</th>
            <th>Scheduled Date of Completion</th>
            <th>Estimated Project Value</th>
            <th>Actual Project Value</th>
            <th>Invoice Raised</th>
            <th>Total Payment Done</th>
            <th>Outstanding Balance</th>
            <th>Status</th>
        </tr>';

// Fetch data and loop through each row
while ($res = mysqli_fetch_assoc($data)) {
    $html .= '
        <tr>
            <td>' . $res['Sr. No.'] . '</td>
            <td>' . $res['NameOfProject'] . '</td>
            <td>' . $res['ClientName'] . '</td>
            <td>' . $res['WorkOrderDate'] . '</td>
            <td>' . $res['SchedDateCompl'] . '</td>
            <td>' . $res['ExpectedVal'] . '</td>
            <td>' . $res['ActualVal'] . '</td>
            <td>' . $res['tcsInvRaised'] . '</td>
            <td>' . $res['TotPymntDone'] . '</td>
            <td>' . $res['OutstndBal'] . '</td>
            <td>' . $res['Status'] . '</td>
        </tr>';
}

$html .= '</table>';

// Write the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF
$mpdf->Output('Project_Data_TCS.pdf', 'D'); // 'D' for downloading

// Close the database connection
mysqli_close($conn);

// Exit script
exit;
?>
