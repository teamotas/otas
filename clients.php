<?php include "connection.php";

error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();
}

$sql="SELECT * from  client ";
$query=mysqli_query($conn,$sql);

include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <style>
    table{
    width:fit-content;

    column-rule-width: 0.5rem;
    /* background-color: #fff;  */
    border-collapse:collapse;
    }
    .tr{
            background-color:#fff; 
        }
        .tr:nth-child(even) {
    background-color: #f2f2f2;
    }
    </style>
</head>
<body>
<section class="home">
<div class="text" style=" margin-top:5.2rem;">
<?php if (mysqli_num_rows($query) > 0) { ?>
    <table border="4" align='center' style="background:scroll;" >
        <thead > 
        <tr>
            <td colspan="100%"  style=" background-color:#4d79ff;  width:2rem; font-size:3rem; text-align: center; font-weight:900; color:#fff; ">
        Client Data
            </td>
        </tr>
        <tr style="color:black; background-color: #99b3ff;">
        <th style=" font-size:2rem; font-weight:800; width:fit-content; height:2rem; padding:0 0.5rem;">Sr. No.</th>
        <th style=" font-size:2rem; font-weight:800; width:fit-content; height:2rem; padding:0 0.5rem;">Client Name</th>
        <th style=" font-size:2rem; font-weight:800; width:fit-content; height:2rem; padding:0 0.5rem;">Client City</th>
        <th style=" font-size:2rem; font-weight:800; width:5rem; height:2rem; padding:0 0.5rem; ">State</th>
        <th style=" font-size:2rem; font-weight:800; width:5rem; height:2rem; padding:0 0.5rem; ">Country</th>
        <th style=" font-size:2rem; font-weight:800; width:fit-content; height:2rem; padding:0 0.5rem;" colspan="">Actions</th>
        </tr>
    </thead>
    <tbody>
<?php
$srNo = 1;
while ($client = mysqli_fetch_assoc($query)) {
$cityId = $client['CityId'];
$cityname = '';
$statename = '';
$countryname = '';

if ($cityId >= 0) {
    $sql = "SELECT c.name AS city_name, s.name AS state_name, co.name AS country_name
            FROM city c
            INNER JOIN state_uts s ON c.state_id = s.id
            INNER JOIN countries co ON s.country_id = co.id
            WHERE c.id = '$cityId'";
    $d2 = mysqli_query($conn, $sql);
    $r2 = mysqli_fetch_assoc($d2);
    $cityname = $r2['city_name'];
    $statename = $r2['state_name'];
    $countryname = $r2['country_name'];
}

        echo ' 
        <tr class="tr" style=" width:fit-content; height:min-content;">
        <td style=" font-size:1.8rem; font-weight:600; padding:0 0.5rem;">&nbsp;&nbsp;&nbsp;' . $srNo . '</td>
        <td style=" font-size:1.8rem; font-weight:600; padding:0 0.5rem;">' . $client["ClientName"] . '</td>
        <td style=" font-size:1.8rem; font-weight:600; padding:0 0.5rem;">' . $cityname . '</td>
        <td style=" font-size:1.8rem; font-weight:600; padding:0 0.5rem;">' . $statename . '</td>
        <td style=" font-size:1.8rem; font-weight:600; padding:0 0.5rem;"> '.$countryname .'</td>
        <td align="center">
            <form action="delete.php" method="post" onclick="return checkdelete()" >
            <input type="hidden" name="delclient" value="true">
            <input type="hidden" name="client_id" value="'.$client["ClientId"].'">
            <input type="submit" class="deletebtn" value="Delete" style="height:4rem; width:fit-content;"  >
            </form>
        </td>
        </tr>
        ';
        $srNo++;
    }
    ?></tbody>
        </table>
   <?php
    }
   else{
    ?>
    <div style=" margin-top:25rem; display:flex; align-items:center; justify-content:center">
        <div><h3> No Client Available </h3></div>
        &nbsp;&nbsp;
        <div>
        <p>Want to create client <a href='create_client.php'>Click here</a></p>
        </div>
    </div>
    <?php
    }
?>
</div>
</section>
</body>
</html>