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
        FROM otasprojectdata prdata
        JOIN otasservicesprice serprice ON prdata.projid=serprice.projid
        JOIN otasprojval prval ON  serprice.projid= prval.projid
        JOIN otasprcandcount count ON prval.projid = count.projid
        JOIN otasprojdates dates ON count.projid = dates.projid
        JOIN stg1pymntdetail stg1 ON dates.projid=stg1.projid
        JOIN stg2pymntdetail stg2 ON stg1.projid=stg2.projid
        JOIN stg3pymntdetail stg3 ON stg2.projid=stg3.projid
        JOIN stg4pymntdetail stg4 ON stg3.projid=stg4.projid
        JOIN stg5pymntdetail stg5 ON stg4.projid=stg5.projid
        JOIN client cl ON prdata.ClientId = cl.ClientId
        LEFT JOIN userotasproject up ON prdata.projid = up.projid
        LEFT JOIN employee em ON up.EmployeeId = em.EmployeeId
        ORDER BY `prdata`.`projid` ASC";       
        $data = mysqli_query($conn, $sql);
        $total = mysqli_num_rows($data);
// Create a new instance of mPDF
$mpdf = new Mpdf();

// Set default header and footer
$mpdf->SetHeader('Quarterly Project Report');
$mpdf->SetFooter('Generated on ' . date('Y-m-d H:i:s'));


// Set content for the PDF
$html = '
    <h1>Quarterly Project Report</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Sr. No.</th>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Work Order Date</th>
            <th>Scheduled Date of Completion</th>
            <th>Estimated Project Value</th>
            <th>Actual Project Value</th>
            <th>CBT Date</th>
            <th>Invoice Raised</th>
            <th>Total Payment Recieved</th>
            <th>Outstanding Balance</th>
            <th>Status</th>
        </tr>';
        $sNo = 1;
// Fetch data and loop through each row
while ($res = mysqli_fetch_assoc($data)) {
    $html .= '
        <tr>
            <td>' . $sNo . '</td>
            <td>' . $res['NameOfProject'] . '</td>
            <td>' . $res['ClientName'] . '</td>
            <td>' . setFormattedDateValue( $res['WorkOrderDate']) . '</td>
            <td>' . setFormattedDateValue( $res['SchedDateCompl']) . '</td>
            <td>' . formatNumberIndianStyle($res['ExpectProjVal']). '</td>
            <td>' . formatNumberIndianStyle($res['ActualProjVal']). '</td>
            <td>' . formatNumberIndianStyle($res['InvAmtRaised']). '</td>
            <td>' . formatNumberIndianStyle($res['AmntRcvdByClient']). '</td>
            <td>' . formatNumberIndianStyle($res['TotOutstndBal']). '</td>
            <td>' . $res['Status'] . '</td>
        </tr>';
        $sNo++;
}

$html .= '</table>';

// Write the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF
$mpdf->Output('Quarterly Project Report.pdf', 'D'); // 'D' for downloading

// Close the database connection
mysqli_close($conn);

// Exit script
exit;
?>
