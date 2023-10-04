<?php
include "connection.php";
include "number_format.php";
include "js/date_format.php";
error_reporting(0);
session_start();

// if (!isset($_SESSION['Super_Admin_ID'])) {
// 	header("location:admin_login.php");
// 	die();
// }else{
    $sql = "SELECT *
    FROM otasprojectdata prdata
    JOIN otasprojval prval ON prdata.projid = prval.projid
    JOIN otaspymntpcnt pcnt ON prval.projid = pcnt.projid
    JOIN otaspymntrcvd rcvd ON pcnt.projid = rcvd.projid
    JOIN otasprcandcount count ON rcvd.projid = count.projid
    JOIN otasprojdates dates ON count.projid = dates.projid
    JOIN otasinvoice invoices ON dates.projid = invoices.projid
    JOIN invoicelive inliv ON invoices.projid = inliv.projid
    JOIN invoiceadmit inad ON inliv.projid = inad.projid
    JOIN invoicecbt incbt ON inad.projid = incbt.projid
    JOIN invoiceresult inres ON incbt.projid = inres.projid
    Join otaspymntamt amt on inres.projid=amt.projid
    Join client cl On prdata.ClientId=cl.ClientId";

$data = mysqli_query($conn, $sql);
$total = mysqli_num_rows($data);

// }
// include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/display_table.css">
    <script defer src="js/app.js"></script>
</head>
<body>
    
    <div class="slider">
        <div class="list">
            <div class="item">
                <main class="table">
                    <section class="table__header">
                        <h1 style="color: white; font-size: 25px;">Project Status 1</h1>
                    </section>
                    <section class="table__body">
                        <table>
                            <thead>
                                <tr >
                                    <th> Sr. No. </th>
                                    <!-- <th> Client Name </th> -->
                                    <th> Project Name </th>
                                    <th> Application Start Date </th>
                                    <!-- <th> Application End Date </th> -->
                                    <th> Candidate Count </th>
                                    <!-- <th> Project Manager </th> -->
                                    <!-- <th> Tcs Developer </th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php
    $srNo = 1;
    mysqli_data_seek($data, 0); // Reset data pointer to the beginning
    while (($res = mysqli_fetch_assoc($data))) {
   
        $formattedExpectCandCount = formatNumberIndianStyle($res["ExpectCandCount"]);
        $formattedActualCanCount = formatNumberIndianStyle($res["ActualCandCount"]);
        echo '
        <tr >
            <td >' . $srNo . '</td>
            <td >' . $res["NameOfProject"] . '</td>
            <td >' ; 
            if ( ($AplicLivDate = $res["AplicLivDate"])!== '0000-00-00') {
                $formattedDate =formatDate($res["AplicLivDate"]);
                echo $formattedDate;
            } else {
                echo '';
            } 
            echo'</td>
            <td >' . $formattedActualCanCount . '</td>
          ';

        
        $srNo++;
    }
    ?>
                                
                            </tbody>
                        </table>
                    </section>
                </main>
            </div>
            <div class="item">
                <!-- <img src="img/2.jpg" alt=""> -->
                <main class="table">
                    <section class="table__header">
                        <h1 style="color: white;">Project Status 2</h1>
                    </section>
                    <section class="table__body">
                        <table>
                            <thead>
                                <tr >
                                <th> Sr. No. </th>
                                    <!-- <th> Client Name </th> -->
                                    <th> Project Name </th>
                                    <th> Application Start Date </th>
                                    <th> Application End Date </th>
                                    <th> Candidate Count </th>
                                    <!-- <th> Project Manager </th> -->
                                    <!-- <th> Tcs Developer </th> -->
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                            </tbody>
                        </table>
                    </section>
                </main>
            </div>
            <div class="item">
                <!-- <img src="img/3.jpg" alt=""> -->
                <main class="table">
                    <section class="table__header">
                        <h1 style="color: white;">Project Status 3</h1>
                    </section>
                    <section class="table__body">
                        <table>
                            <thead>
                                <tr >
                                <th> Sr. No. </th>
                                    <!-- <th> Client Name </th> -->
                                    <th> Project Name </th>
                                    <th> Application Start Date </th>
                                    <th> Application End Date </th>
                                    <th> Candidate Count </th>
                                    <th> Project Manager </th>
                                    <!-- <th> Tcs Developer </th> -->
                                </tr>
                            </thead>
                            <tbody>
                               
                                
                            </tbody>
                        </table>
                    </section>
                </main>
            </div>
         
        </div>
        <div class="buttons">
            <button id="prev"><</button>
            <button id="next">></button>
        </div>
        <ul class="dots">
            <li class="active"></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    <!-- <script defer src="js/app.js"></script> -->
</body>
</html>