<?php
include('connection.php');
error_reporting(0);
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();
}
if(isset($_POST['delTcsProject'])){
    if(isset($_POST['project_id1'])){
      $id1=$_POST['project_id1'];
      $sql = "DELETE prdata, prval, count, dates, cbt, res, pymnt
      FROM tcsprojectdata prdata
      JOIN tcsprojval prval ON prdata.projid = prval.projid
      JOIN tcscandcount count ON prval.projid = count.projid
      JOIN tcsprojdates dates ON count.projid = dates.projid
      JOIN tcsinvoicecbt cbt ON dates.projid = cbt.projid
      JOIN tcsinvoiceresult res ON cbt.projid = res.projid
      JOIN tcspymntstatus pymnt ON res.projid = pymnt.projid
      WHERE prdata.projid = '$id1'";
    
      $data = mysqli_query($conn, $sql);
      if ($data){
            if($data){
              echo"<script>alert('Record Deleted.');</script>";
              ?>
              <meta http-equiv="refresh" content="0  URL=project_data1.php" />
            <?php
            }
            else{
              echo"<script>alert('Failed');</script>";
            }
      }
    }
}

if(isset($_POST['delProject'])){
  if(isset($_POST['project_id'])){
    $id2=$_POST['project_id'];
    $sql = "DELETE prdata, prval,pcnt,rcvd,count, dates,invoices,inliv,inad,incbt,inres,amt
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
    WHERE prdata.projid = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "s", $id2);
      if (mysqli_stmt_execute($stmt)) {
          // Deletion successful
          echo"<script>alert('Record Deleted.');</script>";
          ?>
                <meta http-equiv="refresh" content="0  URL=project_data.php" />
              <?php
      } else {
              // Deletion failed
          echo"<script>alert('Failed');</script>";
      }
      mysqli_stmt_close($stmt);
    } else {
      // Query preparation failed
      ?>
                <meta http-equiv="refresh" content="0  URL=project_data.php" />
              <?php
    }
  }
}
if (isset($_POST['delemployee'])){
if(isset($_POST['employee_id'])){

  $id=$_POST['employee_id'];
  $queryy="DELETE employee,department,roles
  FROM employee 
  JOIN department ON employee.EmployeeId=department.EmployeeId
  JOIN roles ON department.EmployeeId=roles.EmployeeId WHERE employee.EmployeeId='$id'";  

  $data=mysqli_query($conn,$queryy);
  if($data){
      echo"<script>alert('Record Deleted.');
      location.replace('userdata.php');
      </script>";
      ?>
      <!-- <meta http-equiv="refresh" content="0  URL=userdata.php" /> -->
    <?php
  }
  else{
      echo"<script>alert('Failed');</script>";
  }
}
}
if (isset($_POST['delclient'])){
  if(isset($_POST['client_id'])){
  
    $id=$_POST['client_id'];
    $queryy="DELETE FROM `client` WHERE ClientId='$id'";  
  
    $data=mysqli_query($conn,$queryy);
    if($data){
        echo"<script>alert('Record Deleted.');
        location.replace('clients.php');
        </script>";
    }
    else{
        echo"<script>alert('Failed');</script>";
    }
  }
  }