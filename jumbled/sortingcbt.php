<?php
require 'connection.php';
require 'js/format.php';

// $sql = "SELECT *
// FROM otasprojectdata prdata
// JOIN otasservicesprice serprice ON prdata.projid=serprice.projid
// JOIN otasprojval prval ON  serprice.projid= prval.projid
// JOIN otasprcandcount count ON prval.projid = count.projid
// JOIN otasprojdates dates ON count.projid = dates.projid
// JOIN stg1pymntdetail stg1 ON dates.projid=stg1.projid
// JOIN stg2pymntdetail stg2 ON stg1.projid=stg2.projid
// JOIN stg3pymntdetail stg3 ON stg2.projid=stg3.projid
// JOIN stg4pymntdetail stg4 ON stg3.projid=stg4.projid
// JOIN stg5pymntdetail stg5 ON stg4.projid=stg5.projid
// JOIN client cl ON prdata.ClientId = cl.ClientId
// LEFT JOIN userotasproject up ON prdata.projid = up.projid
// LEFT JOIN employee em ON up.EmployeeId = em.EmployeeId
// ORDER BY `prdata`.`projid` ASC";       

// $data = mysqli_query($conn, $sql);
// $res = mysqli_fetch_assoc($data);
// echo (formatMultipleDates($res['CBTDate']));






// Execute SQL query to retrieve CBT dates data
$sql = "SELECT * FROM `otasprojdates` WHERE YEAR(`CBTDate`) = YEAR(CURRENT_DATE()) AND MONTH(`CBTDate`) BETWEEN 1 AND 3";
$result = mysqli_query($conn, $sql);

// Check if any data is retrieved
if (mysqli_num_rows($result) > 0) {
    // Loop through each row of the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Process each row and generate the report
        // You can format and display the data as needed
        echo "CBT Date: " . $row['CBTDate'] . "<br>";
        // Add more processing/report generation logic here
    }
} else {
    // No data found for the selected timeframe
    echo "No CBT dates found for the selected timeframe.";
}
