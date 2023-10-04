<?php
include('connection.php');
error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();

if (isset($_POST['selectedClient1'])) {
    $id = $_POST['selectedClient1'];
    $Q1="SELECT * from client where `ClientId`='$id'";
     $q12=mysqli_query($conn,$Q1);
     $q1=mysqli_fetch_assoc($q12);
 
     //fetching city details from database   
     if($q1['CityId'] >= 0){
         $sql = "SELECT c.name AS city_name, 
         s.name AS state_name
         FROM city c
         INNER JOIN state_uts s ON c.state_id = s.id
         WHERE c.id = '$q1[CityId]'";
         $d2=mysqli_query($conn,$sql);
         $r2=mysqli_fetch_assoc($d2);
         $cityname = $r2['city_name'] . ', ' . $r2['state_name'];     
     }
   
}
// else{
//      header("location:choose_client2.php");
//      die();
    
// }
include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/create2.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <script defer src="js/date_cal.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
  <style>
   </style>
    <title>Create | Project</title>
</head>
<body >

    <div class="container2" style="margin-top:19rem;">
        <h2>Create Project</h2>
      
        <form action="#" method="Post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
            <div class="project-details">
                <div class="inputbox">
                    <span for="clientname" class='details'>Client Name</span>
                    <input type="text" name="clientName" id="clientname" class="input" disabled value="  <?php echo $q1['ClientName'];?>" required>
                </div>
                <div class="inputbox">
                    <span for="clientid" class="details">Client ID</span>
                    <input type="text" name="clientId" id="clientid" class="input" disabled
                    value="  <?php echo $q1['ClientId']?>"required>
                    <input type="hidden" name="clientId" value="<?php echo $q1['ClientId'] ?>">

                </div>
                <div class="inputbox">
                    <span for="clientcity" class="details">Client City</span>
                    <input type="text" name="clientCity" id="clientcity" class="input" disabled 
                    value="  <?php
                    echo $cityname;
                    ?>"
                    required>
                </div>
                <div class="inputbox">
                    <span for="year" class="details">Year<sup>*</sup></span>
                    <input type="number" name="Year" maxlength="4" id="year" class="input" placeholder="Select year Of Project" required>
                </div>
                </div>
                <div class="inputbox projname">
                    <span for="projectname" class="details">Name Of Project<sup>*</sup></span>
                    <input type="text" name="projectName" id="projectname" class="input" placeholder="Enter Project Name Here" required>
                </div>
             <div class="project-details">
                <div class="inputbox">
                    <span for="startDate" class="details">Work Order Date<sup>*</sup></span>
                    <input type="date" name="orderDate" id="startDate" class="input"
                    required onchange="calculateEndDate()">
                </div>
                
                <div class="inputbox">
        <span for="services" class="details">Services</span>
        <div id="servicesContainer" class="input" style="position: relative;">
            <input type="text" id="selectedServices" class="input" readonly>
            <i class='bx bx-chevron-down dropdown-select'></i>
        </div>
        <div class="select-box">
            <div class="select-dropdown">
                <div class="select-header">
                    <input type="checkbox" id="selectAll"> Select All
                </div>
                <div class="select-options">
                    <!-- <input type="checkbox" id="option1" name="services[]" value="Jammer"> Jammer<br> -->
                    <input type="checkbox" id="option2" name="services[]"  value="CCTV Recording"> CCTV Recording<br>
                    <input type="checkbox" id="option3"  name="services[]" value="CCTV Live Streaming"> CCTV Live Streaming<br>
                    <input type="checkbox" id="option4"  name="services[]" value="Iris Scanning"> Iris Scanning<br>
                    <input type="checkbox" id="option5" name="services[]"  value="Biometric Capturing"> Biometric Capturing<br>
                </div>
            </div>
        </div>
    </div>
                <div class="inputbox">
                    <span for="duration" class="details">Duration (In Days)<sup>*</sup></span>
                    <input name="Duration" class="input" type="number" id="duration" min="1" max="365" onchange="calculateEndDate()" placeholder="Enter Duration Of Project" required>
                </div>
                <div class="inputbox">
                    <span for="percandrate" class="details">Per Candidate Rate (Exc. GST)<sup>*</sup></span>
                    <input type="text" name="perCandRate" id="percandrate" class="input" required onchange="calculateEstProjVal()">
                </div>
                <div class="inputbox">
                    <span for="endDate" class='details'>Scheduled Date Of Completion<sup>*</sup></span>
                    <input type="date" name="schedCompl" id="endDate" class="input" readonly required>
                
                </div>
                <div class="inputbox">
                    <span for="actdocompl" class="details">Actual Date Of Completion</span>
                    <input type="date" name="actDOCompl" id="actdocompl" class="input" >
                </div>
                <div class="inputbox">
                    <span for="expcandcount" class="details">Expected Candidate Count<sup>*</sup></span>
                    <input type="text" name="expCandCount" id="expcandcount" class="input" required onchange="calculateEstProjVal()">
                </div>
                <div class="inputbox">
                    <span for="actualcandcount" class="details">Actual Candidate Count</span>
                    <input type="text" name="actualcandCount" id="actualcandcount" class="input" onchange="calculateEstProjVal()">
                </div>
                <div class="inputbox">
                    <span for="estprojval" class="details">Estimated Project Value (Exc. GST)<sup>*</sup></span>
                    <input type="text" name="estProjVal" id="estprojval" class="input" required readonly >
                </div>
                <div class="inputbox">
                    <span for="actprojval" class="details">Actual Project Value (Exc. GST)</span>
                    <input type="text" name="actProjVal" id="actprojval" class="input" readonly>
                </div>
                

                <div class="inputbox" style="margin-top: 1rem;">
                    <span for="AplLivDate" class="details">Application Live Date</span>
                    <input type="date" name="AplLivDate" id="AplLivDate" class="input" >
                </div>
                <div class="inputbox" style="margin-top: 1rem;">
                    <span for="AdmitLivDate" class="details">Admit Card Live Date</span>
                    <input type="date" name="AdmitLivDate" id="AdmitLivDate" class="input" >
                </div>
                
                <div class="inputbox " style="margin-top: 1rem;">
                    <span for="ObjMngDate" class="details">Objection Management Live Date</span>
                    <input type="date" name="ObjMngDate" id="ObjMngDate" class="input" >             
                </div>
             
                <div class="inputbox " style="margin-top: 1rem;">
                    <span for="CBTDate" class="details">CBT Date</span>
                    <input type="date" name="CBTDate" id="CBTDate" class="input" >
                </div>
                
            </div>
            <span style=" color:red; font-size:1.4rem;"><sup>*</sup>All fields are mandatory</span>
            <span class="">
            <input type="submit" value="Save  &  Next" name="save&next"   class="button  input" >
            <!-- style="margin-left: 8rem;" -->
            </span>
        </form>
    </div>
    <script>

 // Get the current year
 var currentYear = new Date().getFullYear();

// Find the input element by its ID
var yearInput = document.getElementById('year');

// Set the default value to the current year
yearInput.value = currentYear;

document.addEventListener("DOMContentLoaded", function() {
    var projectNameInput = document.getElementById("projectname");

    projectNameInput.addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });
});
     // Get references to DOM elements
     const selectAllCheckbox = document.getElementById("selectAll");
        const checkboxes = document.querySelectorAll(".select-options input[type='checkbox']");
        const selectedServicesInput = document.getElementById("selectedServices");
        const servicesContainer = document.getElementById("servicesContainer");
        const selectDropdown = document.querySelector(".select-dropdown");

        // Add event listener to "Select All" checkbox
        selectAllCheckbox.addEventListener("change", function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedServices();
        });

        // Add event listeners to individual checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                updateSelectedServices();
                checkSelectAll();
            });
        });

        // Add click event listener to the dropdown icon and input field
        servicesContainer.addEventListener("click", function () {
            toggleDropdown();
        });

        // Add click event listener to close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            if (!servicesContainer.contains(event.target) && !selectDropdown.contains(event.target)) {
                closeDropdown();
            }
        });

        // Function to toggle the display of the select-dropdown
        function toggleDropdown() {
            if (selectDropdown.style.opacity === "1") {
                closeDropdown();
            } else {
                openDropdown();
            }
        }

        // Function to open the select-dropdown
        function openDropdown() {
            selectDropdown.style.opacity = "1";
            selectDropdown.style.transform = "scaleY(1)";
        }

        // Function to close the select-dropdown
        function closeDropdown() {
            selectDropdown.style.opacity = "0";
            selectDropdown.style.transform = "scaleY(0)";
        }

        // Function to update the selected services input field
        function updateSelectedServices() {
            const selectedServices = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            selectedServicesInput.value = selectedServices.join(", ");
        }

        // Function to check/uncheck "Select All" based on individual checkboxes
        function checkSelectAll() {
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            selectAllCheckbox.checked = allChecked;
        }
    </script>
</body>
</html>
<?php 
    if(isset($_POST['save&next'])){
        $id= mysqli_real_escape_string($conn,$_POST['clientId']);
        $Year= mysqli_real_escape_string($conn,$_POST['Year']);
        $ProjName= mysqli_real_escape_string($conn,$_POST['projectName']);
        $Orderdate= mysqli_real_escape_string($conn,$_POST['orderDate']);
        if (isset($_POST['services']) && is_array($_POST['services'])) {
            $selectedServices = implode(', ', $_POST['services']);}
        $Duration= mysqli_real_escape_string($conn,$_POST['Duration']);
        $SchedDateofCompl=date('Y-m-d', strtotime($Orderdate . ' + ' . $Duration . ' days'));
        $ActDateofCompl=mysqli_real_escape_string($conn,$_POST['actDOCompl']);

        $PerCandRate= mysqli_real_escape_string($conn,$_POST['perCandRate']);
        $ExpCandCount= mysqli_real_escape_string($conn,$_POST['expCandCount']);
        $ActualCandCount= mysqli_real_escape_string($conn,$_POST['actualcandCount']);
        $ExpProjVal= mysqli_real_escape_string($conn,$_POST['estProjVal']);
        $ActProjVal=mysqli_real_escape_string($conn,$_POST['actProjVal']);

        $AplLivDate=mysqli_real_escape_string($conn,$_POST['AplLivDate']);
        $AdmitLivDate=mysqli_real_escape_string($conn,$_POST['AdmitLivDate']);
        $ObjMngDate=mysqli_real_escape_string($conn,$_POST['ObjMngDate']);
        $CBTDate=mysqli_real_escape_string($conn,$_POST['CBTDate']);
        
        $checkid="SELECT * FROM `tcsprojectdata` ORDER BY `projid` DESC LIMIT 1";
        $checkresultid=mysqli_query($conn,$checkid);

        if ($checkresultid) 
        {
            if (mysqli_num_rows($checkresultid) > 0) 
            {
                $row = mysqli_fetch_assoc($checkresultid);
                $lastProjID = $row['projid'];
                $get_numbers = (int) str_replace("PR", "", $lastProjID);
                $id_increase = $get_numbers + 1;
                $get_string = str_pad($id_increase, 10, 0, STR_PAD_LEFT);
                $projID = "PR" . $get_string;
            } 
            else 
            {
                $projID = "PR0000000001";
            }

            $query3="INSERT INTO `tcsprojectdata` (`ClientId`, `projid`, `NameOfProject`, `Year`, `WorkOrderDate`, `Service`, `Duration`, `PerCandRate`, `SchedDateCompl`, `ActDateCompl`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query3);
            if ($stmt) {
                if (!isset($selectedServices)) {
                    $selectedServices = '';
                }
                mysqli_stmt_bind_param($stmt, "sssissidss", $id, $projID, $ProjName, $Year, $Orderdate, $selectedServices, $Duration, $PerCandRate, $SchedDateofCompl, $ActDateofCompl);
                
                if (mysqli_stmt_execute($stmt)) {
                    $projdate="INSERT INTO `tcsprojdates` (`projid`, `AplicLivDate`, `AdmitLivDate`, `ObjMngLivDate`, `CBTDate`) VALUES (?, ?, ?, ?, ?)";
                    $stmt_projdate = mysqli_prepare($conn, $projdate);
                    
                    if ($stmt_projdate) {
                        mysqli_stmt_bind_param($stmt_projdate, "sssss",$projID, $AplLivDate, $AdmitLivDate, $ObjMngDate, $CBTDate);

                        if (mysqli_stmt_execute($stmt_projdate)) {
                            $cancount="INSERT INTO `tcscandcount` (`projid`, `ExpectCandCount`, `ActualCanCount`)VALUES (?, ?, ?)";
                            $stmt_cancount = mysqli_prepare($conn, $cancount); 
                            
                            if ($stmt_cancount) {
                                mysqli_stmt_bind_param($stmt_cancount, "sii", $projID, $ExpCandCount, $ActualCandCount);
                                
                                if (mysqli_stmt_execute($stmt_cancount)) {
                                    $projval="INSERT INTO `tcsprojval` (`projid`, `ExpectProjVal`, `ActualProjVal`) VALUES (?, ?, ?)";
                                    $stmt_projval = mysqli_prepare($conn, $projval);
        
                                    if ($stmt_projval) {
                                        mysqli_stmt_bind_param($stmt_projval, "sdd", $projID, $ExpProjVal, $ActProjVal);
                                        
                                        if (mysqli_stmt_execute($stmt_projval)) {

                $q1="INSERT INTO `tcsinvoicecbt` (`projid`, `cbtInvNum`, `cbtInvAmt`, `cbtInvDate`, `cbtInvFile`) VALUES('$projID', '', '', '', '')";
                mysqli_query($conn,$q1);

                $q23="INSERT INTO `tcsinvoiceresult` (`projid`, `resInvNum`, `resInvDate`, `resInvAmt`, `resInvFile`) VALUES('$projID', '', '', '', '')";
                mysqli_query($conn,$q23);

                $q="INSERT INTO `tcspymntstatus` (`projid`, `cbtpcnt`, `resultpcnt`, `cbtpymntamt`, `resultpymntamt`, `cbtInvNum`, `resInvNum`, `cbtpymntdone`, `respymntdone`) VALUES ('$projID', '', '', '', '', '', '', '', '')";
                mysqli_query($conn,$q);

                                            $_SESSION['Project_ID1'] = $projID;
                                            // header("location:create_prjctt1.php");
                                            echo"
                                            <script>alert('Data inserted.');</script>
                                            ";
                                            ?>
                                            <meta http-equiv="refresh" content="0; url=create_prjct1.php">
                                            <?php
                                            
                                            // exit;
                                        } else {
                                            echo "<script>alert('Record not inserted.');</script>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    echo "<script>alert('Record not inserted.');</script>";
                }
        
                mysqli_stmt_close($stmt);
                mysqli_stmt_close($stmt_projdate);
                mysqli_stmt_close($stmt_cancount);
                mysqli_stmt_close($stmt_projval);
            }
        }
    }
?>



