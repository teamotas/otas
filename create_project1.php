<?php
include "connection.php";
error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();}
if(isset($_SESSION['Project_ID'])) {
     $prID=$_SESSION['Project_ID'];
     $_SESSION['ID']=$prID;
     
    // echo "create Project".$_SESSION['ID'];
    $Q1="SELECT `ActualProjVal` FROM `otasprojval` WHERE projid='$prID'";
    $q12=mysqli_query($conn,$Q1);
    $q1=mysqli_fetch_assoc($q12);
    $projectValue=$q1['ActualProjVal'];
}
else
{
      if(isset($_POST['payment_status'])) 
      {
            if (isset($_POST['project_id'])) 
            {
                $prID = $_POST['project_id'];
                // $prID = isset($_POST['project_id']) ? $_POST['project_id'] : $_SESSION['payment_status']; 
                $_SESSION['update_pymnt_status']=$prID;
                // echo "update_payment_direct ".$_SESSION['update_pymnt_status'];
            }
      }
      else
      {  if(isset($_SESSION['payment_status_update']))
        {
            $prID = $_SESSION['payment_status_update'];
            $_SESSION['pymnt_sts_updt_aftr']=$prID;
            // echo "update_payment_after_update_project_data".$_SESSION['payment_status_update_after_update_pr_data'];
        }
      }

        $sql = "SELECT *
        FROM otasprojectdata prdata
        JOIN otasprojval prval ON prdata.projid = prval.projid where prdata.projid='$prID'";
        
        $data = mysqli_query($conn, $sql);
        // $total = mysqli_num_rows($data);
        $q22=mysqli_fetch_assoc($data);
        $projectValue=$q22['ActualProjVal'];
        
        // Fetch data from the otaspymntpcnt table
        $otaspymntpcntQuery = "SELECT `GoLive`, `AdmitCard`, `CBT`, `Result` FROM `otaspymntpcnt` WHERE projid = '$prID'";
        $otaspymntpcntResult = mysqli_query($conn, $otaspymntpcntQuery);
        if ($otaspymntpcntResult) {
            $otaspymntpcntRow = mysqli_fetch_assoc($otaspymntpcntResult);
        
            // Populate the data into variables
            $pergoLive = $otaspymntpcntRow['GoLive'];
            $peradmitCard = $otaspymntpcntRow['AdmitCard'];
            $percbt = $otaspymntpcntRow['CBT'];
            $perresult = $otaspymntpcntRow['Result'];
        } 

        // Fetch data from the otaspymntamt table
        $otaspymntamtQuery = "SELECT `GoLive`, `AdmitCard`, `CBT`, `Result` FROM `otaspymntamt` WHERE projid = '$prID'";
        $otaspymntamtResult = mysqli_query($conn, $otaspymntamtQuery);
        if ($otaspymntamtResult) {
            $otaspymntamtRow = mysqli_fetch_assoc($otaspymntamtResult);
        
            // Populate the data into variables
            $amtgoLive = $otaspymntamtRow['GoLive'];
            $amtadmitCard = $otaspymntamtRow['AdmitCard'];
            $amtcbt = $otaspymntamtRow['CBT'];
            $amtresult = $otaspymntamtRow['Result'];
        } 

        // Fetch data from the invoicelive table
        $invoiceliveQuery = "SELECT `InvNum`, `InvDate`, `InvAmt`, `InvFile` FROM `invoicelive` WHERE projid = '$prID'";
        $invoiceliveResult = mysqli_query($conn, $invoiceliveQuery);
        if ($invoiceliveResult) {
            $invoiceliveRow = mysqli_fetch_assoc($invoiceliveResult);
        
            // Populate the data into variables
            $liveInvNum = $invoiceliveRow['InvNum'];
            $liveInvDate = $invoiceliveRow['InvDate'];
            $liveInvAmt = $invoiceliveRow['InvAmt'];
            $liveInvFile = $invoiceliveRow['InvFile'];
        } 

        // Fetch data from the invoiceadmit table
        $invoiceadmitQuery = "SELECT `InvNum`, `InvDate`, `InvAmt`, `InvFile` FROM `invoiceadmit` WHERE projid = '$prID'";
        $invoiceadmitResult = mysqli_query($conn, $invoiceadmitQuery);
        if ($invoiceadmitResult) {
            $invoiceadmitRow = mysqli_fetch_assoc($invoiceadmitResult);
        
            // Populate the data into variables
            $admitInvNum = $invoiceadmitRow['InvNum'];
            $admitInvDate = $invoiceadmitRow['InvDate'];
            $admitInvAmt = $invoiceadmitRow['InvAmt'];
            $admitInvFile = $invoiceadmitRow['InvFile'];
        } 

        // Fetch data from the invoicecbt table
        $invoicecbtQuery = "SELECT `InvNum`, `InvDate`, `InvAmt`, `InvFile` FROM `invoicecbt` WHERE projid = '$prID'";
        $invoicecbtResult = mysqli_query($conn, $invoicecbtQuery);
        if ($invoicecbtResult) {
            $invoicecbtRow = mysqli_fetch_assoc($invoicecbtResult);
        
            // Populate the data into variables
            $cbtInvNum = $invoicecbtRow['InvNum'];
            $cbtInvDate = $invoicecbtRow['InvDate'];
            $cbtInvAmt = $invoicecbtRow['InvAmt'];
            $cbtInvFile = $invoicecbtRow['InvFile'];
        } 

        // Fetch data from the invoiceresult table
        $invoiceresultQuery = "SELECT `InvNum`, `InvDate`, `InvAmt`, `InvFile` FROM `invoiceresult` WHERE projid = '$prID'";
        $invoiceresultResult = mysqli_query($conn, $invoiceresultQuery);
        if ($invoiceresultResult) {
            $invoiceresultRow = mysqli_fetch_assoc($invoiceresultResult);
        
            // Populate the data into variables
            $resultInvNum = $invoiceresultRow['InvNum'];
            $resultInvDate = $invoiceresultRow['InvDate'];
            $resultInvAmt = $invoiceresultRow['InvAmt'];
            $resultInvFile = $invoiceresultRow['InvFile'];
        } 
        // Fetch data from the otaspymntrcvd table
        $otaspymntrcvdQuery = "SELECT `GoLive`, `AdmitCard`, `CBT`, `Result` FROM `otaspymntrcvd` WHERE projid = '$prID'";
        $otaspymntrcvdResult = mysqli_query($conn, $otaspymntrcvdQuery);
        if ($otaspymntrcvdResult) {
            $otaspymntrcvdRow = mysqli_fetch_assoc($otaspymntrcvdResult);
        
            // Populate the data into variables
            $rcvdgoLive = $otaspymntrcvdRow['GoLive'];
            $rcvdadmitCard = $otaspymntrcvdRow['AdmitCard'];
            $rcvdcbt = $otaspymntrcvdRow['CBT'];
            $rcvdresult = $otaspymntrcvdRow['Result'];
        } 
}


include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create | Project</title>
    <link rel="stylesheet" href="css/create2.css">
</head>
<body >
    <div class="container2" style="margin-top:15rem;">
    <h2>Payment Status</h2>
        <form action="#" method="Post" enctype="multipart/form-data">
        <?php
        if(isset($_SESSION['ID']))
        {
            $prID=$_SESSION['ID'];
            // echo "Create_project".$prID;
        }
        elseif(isset($_SESSION['update_pymnt_status'])){
            $prID=$_SESSION['update_pymnt_status'];
            // echo 'update_payment_direct'.$prID;
        }
        else{if(isset($_SESSION['pymnt_sts_updt_aftr'])){
            $prID=$_SESSION['pymnt_sts_updt_aftr'];
            // echo 'update_payment_after_update'.$prID;            
        }}
        ?>
        <input type="hidden" name="prID" value="<?php echo $prID ?>">
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Payment Stage(%)</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="liveper" class='details'>Go Live</label>
                        <input type="number" name="liveper" id="liveper" class="input" value="<?php if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){echo $pergoLive;
                        }
                        ?>">
                    </div>
                    <div class="pymnt1">
                        <label for="admitper" class='details'>Admit Card</label>
                        <input type="number" name="admitper" id="admitper" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){ echo $peradmitCard;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="cbtper" class='details'>CBT</label>
                        <input type="number" name="cbtper" id="cbtper" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $percbt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="resper" class='details'>Result</label>
                        <input type="number" name="resper" id="resper" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $perresult;
                        }?>">
                    </div>
                </div>
            </div>
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Payment Stage (Amount)(Exc. GST)</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="livepymnt" class='details'>Go Live</label>
                        <input type="text" name="livepymnt" id="livepymnt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $amtgoLive;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="admitpymnt" class='details'>Admit Card</label>
                        <input type="text" name="admitpymnt" id="admitpymnt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $amtadmitCard;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="cbtpymnt" class='details'>CBT</label>
                        <input type="text" name="cbtpymnt" id="cbtpymnt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $amtcbt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="respymnt" class='details'>Result</label>
                        <input type="text" name="respymnt" id="respymnt" class="input" readonly value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $amtresult;
                        }?>">
                    </div>
                </div>
            </div>
            
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Invoice Amount (Exc. GST)</span>
                </div>
                <div class="">
                    <span class=' heading1'>Go Live</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="invnumlive" class='details1'>Invoice Number</label>
                        <input type="text" name="invnumlive" id="invnumlive" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $liveInvNum;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invdatelive" class='details1'>Invoice Date</label>
                        <input type="date" name="invdatelive" id="invdatelive" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $liveInvDate;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invamtlive" class='details1'>Amount</label>
                        <input type="text" name="invamtlive" id="invamtlive" class="input" onchange="totinvamt()" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $liveInvAmt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invfilelive" class='details1'>Upload Invoice</label>
                        <input type="file" name="invfilelive" id="invfilelive" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $liveInvFile;
                        }?>">
                    </div>
                </div>

                <div class="">
                    <span class=' heading1'>Admit Card</span>
                </div>
                <div class="stage ">
                <div class="pymnt1">
                        <label for="invnumadmit" class='details1'>Invoice Number</label>
                        <input type="text" name="invnumadmit" id="invnumadmit" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $admitInvNum;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invdateadmit" class='details1'>Invoice Date</label>
                        <input type="date" name="invdateadmit" id="invdateadmit" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $admitInvDate;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invamtadmit" class='details1'>Amount</label>
                        <input type="text" name="invamtadmit" id="invamtadmit" class="input" onchange="totinvamt()" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $admitInvAmt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invfileadmit" class='details1'>Upload Invoice</label>
                        <input type="file" name="invfileadmit" id="invfileadmit" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $admitInvFile;
                        }?>">
                    </div>
                </div>

                <div class="">
                    <span class=' heading1'>CBT</span>
                </div>
                <div class="stage ">
                <div class="pymnt1">
                        <label for="invnumcbt" class='details1'>Invoice Number</label>
                        <input type="text" name="invnumcbt" id="invnumcbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $cbtInvNum;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invdatecbt" class='details1'>Invoice Date</label>
                        <input type="date" name="invdatecbt" id="invdatecbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $cbtInvDate;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invamtcbt" class='details1'>Amount</label>
                        <input type="text" name="invamtcbt" id="invamtcbt" onchange="totinvamt()" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $cbtInvAmt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invfilecbt" class='details1'>Upload Invoice</label>
                        <input type="file" name="invfilecbt" id="invfilecbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $cbtInvFile;
                        }?>">
                    </div>
                </div>


                <div class="">
                    <span class=' heading1'>Result</span>
                </div>
                <div class="stage ">
                <div class="pymnt1">
                        <label for="invnumres" class='details1'>Invoice Number</label>
                        <input type="text" name="invnumres" id="invnumres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $resultInvNum;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invdateres" class='details1'>Invoice Date</label>
                        <input type="date" name="invdateres" id="invdateres" class="input" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $resultInvDate;
                        }?>" >
                    </div>
                    <div class="pymnt1">
                        <label for="invamtres" class='details1'>Amount</label>
                        <input type="text" name="invamtres" id="invamtres" onchange="totinvamt()" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $resultInvAmt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invfileres" class='details1'>Upload Invoice</label>
                        <input type="file" name="invfileres" id="invfileres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $resultInvFile;
                        }?>">
                    </div>
                </div>

            </div>
            <div class="payment-details input-container">
                <div class="">
                    <span class='heading'>Total Amount of Invoice Raised (Exc. GST)</span>
                </div>
                <input type="text" name="invraise" id="invraise" class="input " style="width:91%; margin: 0 0rem 0 3rem; " onchange="outstnd('invraise', 'amountrcvd','outstnd')" readonly placeholder="Enter amount" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $q22['InvAmtRaised'];
                        }?>"><div class="fixed-text">(Rs. in Crores)</div>
            </div>

            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Payment Recieved (Exc. GST)</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="livepymntrcvd" class='details'>Go Live</label>
                        <input type="text" name="livepymntrcvd" id="livepymntrcvd" class="input" onchange="calculateTotal()" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $rcvdgoLive;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="admitpymntrcvd" class='details'>Admit Card</label>
                        <input type="text" name="admitpymntrcvd" id="admitpymntrcvd" class="input" onchange="calculateTotal()" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $rcvdadmitCard;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="cbtpymntrcvd" class='details'>CBT</label>
                        <input type="text" name="cbtpymntrcvd" id="cbtpymntrcvd" class="input" onchange="calculateTotal()" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $rcvdcbt;
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="respymntrcvd" class='details'>Result</label>
                        <input type="text" name="respymntrcvd" id="respymntrcvd" class="input" onchange="calculateTotal()" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $rcvdresult;
                        }?>">
                    </div>
                </div>
            </div>
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Total  (Excluding GST)</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1 input-container">
                        <label for="amount" class='details'>Amount Recieved from Client</label>
                        <input type="text" name="totpymntdonebyclient" id="amountrcvd"  class="input " onchange="outstnd('invraise', 'amountrcvd','outstnd')" style="width: 33rem;" readonly placeholder="Enter amount" value="<?php  if(isset($_SESSION['update_pymnt_status']) || isset($_SESSION['pymnt_sts_updt_aftr'])){
                            echo $q22['AmntRcvdByClient'];
                        }?>"><div class="fixed-text2">(Rs. in Crores)</div>
                        
                    </div>
                    <div class="pymnt1 input-container">
                        <label for="outstnd" class='details'>Total Outstanding Balance</label>
                        <input type="text" name="outstnd" id="outstnd" class="input " readonly style="width: 33rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['TotOutstndBal'];
                        }?>"><div class="fixed-text2">(Rs. in Crores)</div>
                    </div>
                </div>
            </div>
            

                
            <span class="centre">
        <input type="submit" value="Submit" name="submitpymnt">
        </span>
        </form>
    </div>

    <script> 
    var projectValue = <?php echo json_encode($projectValue); ?>;
</script>
<script defer src="js/amount_cal.js"></script>

</body>
</html>
<?php
if(isset($_POST['submitpymnt'])){
    // echo"Form submitted";
    
    
    $prID=mysqli_real_escape_string($conn,$_POST['prID']);
    // Payment Stage(%)
    $liveper= mysqli_real_escape_string($conn,$_POST['liveper']);
    $admitper= mysqli_real_escape_string($conn,$_POST['admitper']);
    $cbtper= mysqli_real_escape_string($conn,$_POST['cbtper']);
    $resper= mysqli_real_escape_string($conn,$_POST['resper']);
 
    // Payment Amount
    $livepymnt= mysqli_real_escape_string($conn,$_POST['livepymnt']);
    $admitpymnt= mysqli_real_escape_string($conn,$_POST['admitpymnt']);
    $cbtpymnt= mysqli_real_escape_string($conn,$_POST['cbtpymnt']);
    $respymnt= mysqli_real_escape_string($conn,$_POST['respymnt']);

    //live invoice data  = number  .date  .amount  .file
    $invnumlive= mysqli_real_escape_string($conn,$_POST['invnumlive']);
    $invdatelive=mysqli_real_escape_string($conn,$_POST['invdatelive']);
    $invamtlive=mysqli_real_escape_string($conn,$_POST['invamtlive']);
    // upload file
    $filename1=$_FILES['invfilelive']['name'];
    $tempname1=$_FILES['invfilelive']['tmp_name'];
    $folder1='invoices/'. $filename1;
    move_uploaded_file($tempname1,$folder1);
    $invfilelive = $folder1;
    
    //admit invoice data  = number  .date  .amount  .file
    $invnumadmit= mysqli_real_escape_string($conn,$_POST['invnumadmit']);
    $invdateadmit=mysqli_real_escape_string($conn,$_POST['invdateadmit']);
    $invamtadmit=mysqli_real_escape_string($conn,$_POST['invamtadmit']);
    // upload file
    $filename2=$_FILES['invfileadmit']['name'];
    $tempname2=$_FILES['invfileadmit']['tmp_name'];
    $folder2='invoices/'. $filename2;
    move_uploaded_file($tempname2,$folder2);
    $invfileadmit = $folder2;

    //cbt invoice data  = number  .date  .amount  .file
    $invnumcbt= mysqli_real_escape_string($conn,$_POST['invnumcbt']);
    $invdatecbt=mysqli_real_escape_string($conn,$_POST['invdatecbt']);
    $invamtcbt=mysqli_real_escape_string($conn,$_POST['invamtcbt']);
    // upload file
    $filename3=$_FILES['invfilecbt']['name'];
    $tempname3=$_FILES['invfilecbt']['tmp_name'];
    $folder3='invoices/'. $filename3;
    move_uploaded_file($tempname3,$folder3);
    $invfilecbt = $folder3;

    //result invoice data  = number  .date  .amount  .file
    $invnumres= mysqli_real_escape_string($conn,$_POST['invnumres']);
    $invdateres=mysqli_real_escape_string($conn,$_POST['invdateres']);
    $invamtres=mysqli_real_escape_string($conn,$_POST['invamtres']);
    // upload file
    $filename4=$_FILES['invfileres']['name'];
    $tempname4=$_FILES['invfileres']['tmp_name'];
    $folder4='invoices/'. $filename4;
    move_uploaded_file($tempname4,$folder4);
    $invfileres = $folder4;

    //Payment Recieved By Client
    $livepymntrcvd= mysqli_real_escape_string($conn,$_POST['livepymntrcvd']);
    $admitpymntrcvd= mysqli_real_escape_string($conn,$_POST['admitpymntrcvd']);
    $cbtpymntrcvd= mysqli_real_escape_string($conn,$_POST['cbtpymntrcvd']);
    $respymntrcvd= mysqli_real_escape_string($conn,$_POST['respymntrcvd']);

    //Total Payment Recieved by Client
    $totpymntdonebyclient= mysqli_real_escape_string($conn,$_POST['totpymntdonebyclient']);
    
    //------------------------------query start--------------------------------

    // query1 for percentage
    $q1="UPDATE `otaspymntpcnt` SET `GoLive`='$liveper',`AdmitCard`='$admitper',`CBT`='$cbtper',`Result`='$resper' WHERE `projid`='$prID'";
   
    
    if(mysqli_query($conn,$q1))
    {
        // query2 stage amount percent wise
        $q2="UPDATE `otaspymntamt` SET `GoLive`='$livepymnt',`AdmitCard`='$admitpymnt',`CBT`='$cbtpymnt',`Result`='$respymnt' WHERE `projid`= '$prID' ";
        mysqli_query($conn,$q2);
    }else {
        echo "Error in query 1: " . mysqli_error($conn);
    }

    //++++++++++++++++++++++++invoices data stage wise+++++++++++++++++++++++++
    // query3 live invoice data
    $q3=" UPDATE `invoicelive` SET `InvNum`='$invnumlive',`InvDate`='$invdatelive',`InvAmt`='$invamtlive',`InvFile`='$invfilelive' WHERE `projid`='$prID'";
    $q31=mysqli_query($conn,$q3);
    
    if($q31)
    {
        // query4 admit invoice data
        $q4=" UPDATE `invoiceadmit` SET `InvNum`='$invnumadmit',`InvDate`='$invdateadmit',`InvAmt`='$invamtadmit',`InvFile`='$invfileadmit' WHERE `projid`='$prID'";
        $q41=mysqli_query($conn,$q4);

        if($q41)
        {
            // query5 cbt invoice data
            $q5="UPDATE `invoicecbt` SET `InvNum`='$invnumcbt',`InvDate`='$invdatecbt',`InvAmt`='$invamtcbt',`InvFile`='$invfilecbt' WHERE `projid`='$prID'";
            $q51= mysqli_query($conn,$q5);

            if($q51)
            {
                // query6 result invoice data
                $q6="UPDATE `invoiceresult` SET `InvNum`='$invnumres',`InvDate`='$invdateres',`InvAmt`='$invamtres',`InvFile`='$invfileres' WHERE `projid`='$prID'";
                $q61=mysqli_query($conn,$q6);
                
                if($q61)
                {
                    //query for inserting invoice numbers of all stage
                    if( $q31|| $q41 || $q51 || $q61  )
                    {
                        $invoices="UPDATE `otasinvoice` SET `GoLive`='$invnumlive',`AdmitCard`= '$invnumadmit',`CBT`='$invnumcbt',`Result`='$invnumres' WHERE `projid`='$prID'";
                        $insinvoice=mysqli_query($conn,$invoices);
                    }
                }
            }
        }
    }
   //******************Payment Recieved By Client*********************
    // query7 payment recieved by client
    $q7="UPDATE `otaspymntrcvd` SET `GoLive`='$livepymntrcvd',`AdmitCard`='$admitpymntrcvd',`CBT`='$cbtpymntrcvd',`Result`='$respymntrcvd' WHERE `projid`='$prID'";
        if(mysqli_query($conn,$q7))
        {
         // query8 total payment recieved by client
            // Prepare the query
            $q8 = "UPDATE `otasprojectdata` SET `AmntRcvdByClient` = ? WHERE `projid` = ?";
            $stmt = mysqli_prepare($conn, $q8);
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "is", $totpymntdonebyclient, $prID);
            // Execute the statement
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt); 

            echo "
            <script>
                alert('Data inserted successfully.');
            </script>
            ";
            ?>
            <meta http-equiv="refresh" content="0; url=project_data.php">
            <?php
            }
            else{
            echo"
            <script>
                alert('Data not inserted');
            </script>
            ";}
}


unset($_SESSION['pymnt_sts_updt_aftr']);
unset($_SESSION['payment_status_update']);
unset($_SESSION['update_pymnt_status']);
unset($_SESSION['Project_ID']);
unset($_SESSION['ID']);

?>














