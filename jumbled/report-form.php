<?php
    include('connection.php'); 
     include "sidebar.php";
    // error_reporting(0);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // session_start();
    if(($adminType==='Admin')||($userType==='User')){
    // if (isset($_POST['updateprojectdata'])) {
    //     if (isset($_POST['project_id'])) {
    //         // $_SESSION['update_prjct_status']=$_POST['project_id'];
            

    //     }
    // }
    $_SESSION['update_prjct_status']='PR0000000001';

    $prID = $_SESSION['update_prjct_status'];
    $sql = "SELECT *
    FROM otasprojectdata prdata
    JOIN otasprojval prval ON prdata.projid = prval.projid
    JOIN otasprcandcount count ON prval.projid = count.projid
    JOIN otasprojdates dates ON count.projid = dates.projid
    JOIN otasservicesprice serprice ON dates.projid=serprice.projid
    Join client cl On prdata.ClientId=cl.ClientId
    where prdata.projid='$prID'";

    $data = mysqli_query($conn, $sql);
    $total = mysqli_num_rows($data);
    $q3=mysqli_fetch_assoc($data);
    $id=$q3['ClientId'];
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
  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/multiple_date_picker.css">
        <link rel="stylesheet" href="/Otas/flatpickr-master/dist/flatpickr.min.css">
        <title>Report | Form</title>
    <style>
      

    </style>
    </head>
    <body >
    <section class="home" >  
        <div class="container"  >
            <?php //$prID = $_SESSION['update_prjct_status'];?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="Post" autocomplete="off" enctype="application/x-www-form-urlencoded" >
                <p id="heading">Update Project Data</p>
                <div class="project-details">
                    <div class="inputbox">
                        <span for="clientname" class='details'>Client Name<sup>*</sup>&nbsp; &nbsp;<?php echo $q1['ClientId']?></span>
                        <input type="text" required name="clientName" id="clientname" class="input" disabled value="<?php echo $q1['ClientName'];?>">
                    </div>
                    <div class="inputbox projname">
                        <span for="projectname" class="details">Name Of Project<sup>*</sup> &nbsp; &nbsp;<?php  if(isset($_SESSION['update_prjct_status'])){ echo $prID;}?></span>
                        <input type="text" required name="projectName" id="projectname" class="input" placeholder="Enter Project Name Here" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['NameOfProject'];}?>">
                        <input type="hidden" required name="projectID" disabled id="projectID" class="input" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $prID;}?>">
                    </div>

                    <div class="inputbox">
                        <span for="startDate" class="details">Date of LOA(mm/dd/yyyy)<sup>*</sup></span>
                        <input type="date" name="orderDate" id="startDate" class="input" required
                        value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['WorkOrderDate'];}?>">
                    </div>
                    <div class="inputbox">
                        <span for="duration" class="details">Duration (In Days)<sup>*</sup></span>
                        <input name="Duration" class="input" type="number" id="duration" min="1" max="365" placeholder="Enter Duration Of Project"  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['Duration'];}?>" required>
                    </div>
                    <div class="inputbox">
                        <span for="endDate" class='details'>Sched. Date of Compl.(mm/dd/yyyy)</span>
                        <input type="date" name="schedCompl" id="endDate" class="input" readonly value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['SchedDateCompl'];}?>" required>
                    </div>
                    <div class="inputbox">
                        <span for="estprojval" class="details">Exp Project Val(Services + QP)(In Rs.)</span>
                        <input type="text" name="estProjVal" id="estprojval" class="input" readonly  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ExpectProjVal'];}?>">
                    </div>

                    <div class="inputbox">
                        <span for="actprojval" class="details">Act. Project Val.(Services + QP)(In Rs.)</span>
                        <input type="text" name="actProjVal" id="actprojval" class="input" readonly  value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['ActualProjVal'];}?>">
                    </div>

                    <div class="inputbox " >
                        <label for="CBTDate" class="details">CBT Date</label>
                        <input type="text" name="CBTDate" id="CBTDate" class="input" placeholder="Select multiple date" value="<?php  if(isset($_SESSION['update_prjct_status'])) {
                            $cleaned_dates = stripslashes($q3['CBTDate']);
                            $cleaned_dates = trim($cleaned_dates, '"');
                            $dates = explode(', ', $cleaned_dates);
                            if (!empty($dates)) {
                                $formatted_dates = implode(", ", $dates);
                                echo $formatted_dates;
                            }}
                            ?>">
                    </div>
                    <div class="inputbox ">
                        <span for="" class="details">CBT Shifts </span>
                        <input type="number" name="NoOfCBTShifts" id="" class="input" placeholder="Enter No Of Shifts" value="<?php  if(isset($_SESSION['update_prjct_status'])){ echo $q3['NoOfCBTShifts'];}?>">
                    </div>
                    <div class="inputbox" >
                        <span for="prjctstts" class="details">Project Status<sup>*</sup></span>
                        <select name="prjctstts" id="prjctstts" class="input" required autocomplete="off">
                            <option value disabled >--Select--</option>
                            <option value="Ongoing" <?php if($q3['Status'] =="Ongoing"){echo"selected";}?>>Ongoing</option>
                            <option value="Amount Pending" <?php if($q3['Status'] =="Amount Pending"){echo "selected";}?>>Amount Pending</option>
                            <option value="Completed" <?php if($q3['Status'] == "Completed"){echo "selected";}?>>Completed</option>
                        </select>
                    </div>
                    <div class="inputbox " >
                        <span for="DelayReason" class="details">Delay Reason/ Remarks</span>
                        <textarea id="DelayReason" name="DelayReason" class="input" rows="5" cols="100%" placeholder="Enter Delay Reason/ Remarks"><?php if(isset($_SESSION['update_prjct_status'])) { echo $q3['DelayReason']; } ?></textarea>
                    </div> 
                </div>
                
                <span class=""><input type="submit" value="Update" name="updateprjctdata"   class="button  input" ></span> 
            </form>
        </div>
        <script src="/Otas/flatpickr-master/dist/flatpickr.min.js"></script>
        <script defer src="js/report-form.js"></script>
    </section>
    
    </body>
</html>
<?php 
    if(isset($_POST['updateprjctdata'])){
        $ProjName= mysqli_real_escape_string($conn,$_POST['projectName']);
        $Orderdate= mysqli_real_escape_string($conn,$_POST['orderDate']);
        $Duration= mysqli_real_escape_string($conn,$_POST['Duration']);
        //scheduled date of completion
        $SchedDateofCompl=date('Y-m-d', strtotime($Orderdate . ' + ' . $Duration . ' days'));

        $ExpProjVal= mysqli_real_escape_string($conn, str_replace(',', '', $_POST['estProjVal']));
        $ActProjVal=mysqli_real_escape_string($conn, str_replace(',', '', $_POST['actProjVal']));

        $CBTDateArray = $_POST['CBTDate'];
        $CBTDateJSON = json_encode($CBTDateArray);
        $CBTDateEscaped = mysqli_real_escape_string($conn, $CBTDateJSON);

        // $ResultSub=mysqli_real_escape_string($conn,$_POST['ResultSub']);
        $NoOfCBTShifts=mysqli_real_escape_string($conn,$_POST['NoOfCBTShifts']);
       
        $prjctstts=mysqli_real_escape_string($conn,$_POST['prjctstts']);

        $DelayReason=mysqli_real_escape_string($conn,$_POST['DelayReason']);

        $prID = $_SESSION['update_prjct_status'];

        // Prepare the SQL statement with placeholders
        $query3 = "UPDATE `otasprojectdata` SET `NameOfProject`=?, `WorkOrderDate`=?,`Duration`=?, `SchedDateCompl`=?, `Status`=? ,`DelayReason`=? WHERE `projid`=?";
        $stmt = mysqli_prepare($conn, $query3);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssissss", $ProjName, $Orderdate, $Duration, $SchedDateofCompl,  $prjctstts,$DelayReason, $prID);
            
            if (mysqli_stmt_execute($stmt)) {
                $projdateQuery = "UPDATE `otasprojdates` SET `CBTDate`=?,`NoOfCBTShifts`=? WHERE `projid`=?";

                $stmt_projdate = mysqli_prepare($conn, $projdateQuery);

                if($stmt_projdate){
                    mysqli_stmt_bind_param($stmt_projdate, "sss",$CBTDateEscaped ,$NoOfCBTShifts,$prID);

                    if(mysqli_stmt_execute($stmt_projdate)){
                        echo "<script>alert('Data Updated.');</script>";
                        ?>
                        <meta http-equiv="refresh" content="0; url=project_data.php">
                        <?php
                    } 
                    else 
                    {
                        echo "<script>alert('Record not updated.');</script>";
                    }
                }
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt_projdate);
        mysqli_stmt_close($stmt_cancount);
        mysqli_stmt_close($stmt_projval);
    }
}
?>
