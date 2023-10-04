<?php
include "connection.php";

error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();

if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();}
if(isset($_SESSION['Project_ID1']) ) {
    $prID =$_SESSION['Project_ID1'];
    $_SESSION['ID1']=$prID;
    // echo "create Project".$_SESSION['ID1'];
     
    $Q1="SELECT `ActualProjVal` FROM `tcsprojval` WHERE projid='$prID'";
    $q12=mysqli_query($conn,$Q1);
    $q1=mysqli_fetch_assoc($q12);
    $projectValue=$q1['ActualProjVal'];
}
else
{
      if(isset($_POST['payment_status1'])) 
      {
            if (isset($_POST['project_id1'])) 
            {
                $prID = $_POST['project_id1'];
                // $prID = isset($_POST['project_id']) ? $_POST['project_id'] : $_SESSION['payment_status']; 
                $_SESSION['update_pymnt_status1']=$prID;
                // echo "update_payment_direct ".$_SESSION['update_pymnt_status1'];
            }
      }
      else
      {  if(isset($_SESSION['payment_status_update1']))
        {
            $prID = $_SESSION['payment_status_update1'];
            $_SESSION['pymnt_sts_updt_aftr1']=$prID;
            // echo "update_payment_after_update_project_data".$_SESSION['pymnt_sts_updt_aftr1'];
        }
      }

        $q2 = "SELECT * FROM tcsprojectdata prdata
        JOIN tcsprojval prval ON prdata.projid = prval.projid
        JOIN tcsinvoicecbt cbt ON prval.projid= cbt.projid
        JOIN tcsinvoiceresult  res ON cbt.projid= res.projid
        JOIN tcspymntstatus pymnt ON res.projid=pymnt.projid  where prdata.projid='$prID'";
        $q21=mysqli_query($conn,$q2);
        $q22=mysqli_fetch_assoc($q21);
        $projectValue=$q22['ActualProjVal'];
// }
  
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
<body>
    <div class="container2 " style="margin-top: 5rem;">
    <h2>Payment Status</h2>
        <form action="#" method="Post" enctype="multipart/form-data">
        <?php
        if(isset($_SESSION['ID1']))
        {
            $prID=$_SESSION['ID1'];
            // echo "Create_project".$prID;
        }
        elseif(isset($_SESSION['update_pymnt_status1'])){
            $prID=$_SESSION['update_pymnt_status1'];
            // echo 'update_payment_direct'.$prID;
        }
        else{if(isset($_SESSION['pymnt_sts_updt_aftr1'])){
            $prID=$_SESSION['pymnt_sts_updt_aftr1'];
            // echo 'update_payment_after_update'.$prID;            
        }}
        ?>
<input type="hidden" name="prID1" value="<?php echo $prID ?>">
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Payment Stage(%)</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="cbtper" class='details'>CBT</label>
                        <input type="number" name="cbtper" id="cbtper" class="input" style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                                $cbtperValue = $q22['cbtpcnt'];
                                echo ($cbtperValue !== null  || $cbtperValue !== 0) ? $cbtperValue : '';
                            }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="resper" class='details'>Result</label>
                        <input type="number" name="resper" id="resper" class="input" style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['resultpcnt'];
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
                        <label for="cbtpymnt" class='details'>CBT</label>
                        <input type="text" name="cbtpymnt" id="cbtpymnt" class="input" readonly style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['cbtpymntamt'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="respymnt" class='details'>Result</label>
                        <input type="text" name="respymnt" id="respymnt" class="input" readonly style="width: 35rem;" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['resultpymntamt'];
                        }?>">
                    </div>
                </div>
            </div>
            
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Invoice Amount (Exc. GST)</span>
                </div>
                <div class="">
                    <span class=' heading1'>CBT</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="invnumcbt" class='details1'>Invoice Number</label>
                        <input type="text" name="invnumcbt" id="invnumcbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['cbtInvNum'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invdatecbt" class='details1'>Invoice Date</label>
                        <input type="date" name="invdatecbt" id="invdatecbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['cbtInvDate'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invamtcbt" class='details1'>Amount</label>
                        <input type="text" name="invamtcbt" id="invamtcbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['cbtInvAmt'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invfilecbt" class='details1'>Upload Invoice</label>
                        <input type="file" name="invfilecbt" id="invfilecbt" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['cbtInvFile'];
                        }?>">
                    </div>
                </div>

                <div class="">
                    <span class=' heading1'>Result</span>
                </div>
                <div class="stage ">
                <div class="pymnt1">
                        <label for="invnumres" class='details1'>Invoice Number</label>
                        <input type="text" name="invnumres" id="invnumres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['resInvNum'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invdateres" class='details1'>Invoice Date</label>
                        <input type="date" name="invdateres" id="invdateres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['resInvDate'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invamtres" class='details1'>Amount</label>
                        <input type="text" name="invamtres" id="invamtres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['resInvAmt'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="invfileres" class='details1'>Upload Invoice</label>
                        <input type="file" name="invfileres" id="invfileres" class="input"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['resInvFile'];
                        }?>">
                    </div>
                </div>

            </div>
                
            <div class="payment-details ">
                <div class="">
                    <span class='heading'>Payment Done (Exc. GST)</span>
                </div>
                <div class="stage ">
                    <div class="pymnt1">
                        <label for="cbtpymntrcvd" class='details'>CBT</label>
                        <input type="text" name="cbtpymntdone" id="cbtpymntrcvd" class="input"  style="width: 35rem;" onchange="calculateTotal()"  value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['cbtpymntdone'];
                        }?>">
                    </div>
                    <div class="pymnt1">
                        <label for="respymntrcvd" class='details'>Result</label>
                        <input type="text" name="respymntdone" id="respymntrcvd" class="input" style="width: 35rem;" onchange="calculateTotal()" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['respymntdone'];
                        }?>">
                    </div>
                </div>
            </div>
            <div class="payment-details input-container">
                <div class="">
                    <span class='heading'>Total Payment Done </span>
                </div>
                <input type="text" name="totpymntdone" id="amount" class="input projname" readonly placeholder="Enter amount" value="<?php  if(isset($_SESSION['update_pymnt_status1']) || isset($_SESSION['pymnt_sts_updt_aftr1'])){
                            echo $q22['TotalPaymentDone'];
                        }?>"><div class="fixed-text">(Rs. in Crores)(Exc. GST)</div>
            </div>

            <span class="centre">
        <input type="submit" value="Submit" name="submitpymnt">
        </span>
        </form>
    </div>

 <script>
    function calculatePaymentAmount(percentage, projectValue) {
        return parseFloat((percentage / 100) * projectValue).toFixed(2);
    }

    const projectValue = <?php echo $projectValue; ?>;

    
    const cbtperInput = document.getElementById("cbtper");
    const resperInput = document.getElementById("resper");
    
   
    const cbtpymntInput = document.getElementById("cbtpymnt");
    const respymntInput = document.getElementById("respymnt");

    function updatePaymentInputs() {
        
        let cbtper = parseFloat(cbtperInput.value) || 0;
        let resper = parseFloat(resperInput.value) || 0;

        const totalPercentage =  cbtper + resper;

        if (totalPercentage > 100) {
            // If total percentage is greater than 100, show an error message and reset the inputs
            alert("Total percentage cannot exceed 100%");
           
            cbtperInput.value = "";
            resperInput.value = "";
            return;
        }

        cbtpymntInput.value = calculatePaymentAmount(cbtper, projectValue); 
        respymntInput.value = calculatePaymentAmount(resper, projectValue);
    }
 
    cbtperInput.addEventListener("input", updatePaymentInputs);
    resperInput.addEventListener("input", updatePaymentInputs);


    function calculateTotal() {
   
    var cbtPymnt = parseFloat(document.getElementById("cbtpymntrcvd").value) || 0;
    var resultPymnt = parseFloat(document.getElementById("respymntrcvd").value) || 0;
    
    var totalPymnt = cbtPymnt + resultPymnt;
    // var actualProjValue = parseFloat(document.getElementById("actprojval").value) || 0;
    
    if (totalPymnt > projectValue) {

        alert("Total payment received cannot exceed actual project value.");
       resultpymnt.value = "";
        return;
    }
    
    document.getElementById("amount").value = totalPymnt.toFixed(2);
    }
</script>

</body>
</html>
<?php
if(isset($_POST['submitpymnt']))
{   
    $prID=mysqli_real_escape_string($conn,$_POST['prID1']);
    // Payment Stage(%)
    $cbtper= mysqli_real_escape_string($conn,$_POST['cbtper']);
    $resper= mysqli_real_escape_string($conn,$_POST['resper']);
    
    // Payment Amount
    $cbtpymnt= mysqli_real_escape_string($conn,$_POST['cbtpymnt']);
    $respymnt= mysqli_real_escape_string($conn,$_POST['respymnt']);

     //cbt invoice data  = number  .date  .amount  .file
     $invnumcbt= mysqli_real_escape_string($conn,$_POST['invnumcbt']);
     $invdatecbt=mysqli_real_escape_string($conn,$_POST['invdatecbt']);
     $invamtcbt=mysqli_real_escape_string($conn,$_POST['invamtcbt']);
     // upload file
     $filename3=$_FILES['invfilecbt']['name'];
     $tempname3=$_FILES['invfilecbt']['tmp_name'];
     $folder3='tcs_invoices/'. $filename3;
     move_uploaded_file($tempname3,$folder3);
     $invfilecbt = $folder3;
 
     //result invoice data  = number  .date  .amount  .file
     $invnumres= mysqli_real_escape_string($conn,$_POST['invnumres']);
     $invdateres=mysqli_real_escape_string($conn,$_POST['invdateres']);
     $invamtres=mysqli_real_escape_string($conn,$_POST['invamtres']);
     // upload file
     $filename4=$_FILES['invfileres']['name'];
     $tempname4=$_FILES['invfileres']['tmp_name'];
     $folder4='tcs_invoices/'. $filename4;
     move_uploaded_file($tempname4,$folder4);
     $invfileres = $folder4;

     $cbtpymntdone= mysqli_real_escape_string($conn,$_POST['cbtpymntdone']);
     $respymntdone= mysqli_real_escape_string($conn,$_POST['respymntdone']);

    //Total Payment Done
    $totpymntdone= mysqli_real_escape_string($conn,$_POST['totpymntdone']);
 
     //------------------------------query start--------------------------------
     
    $Q="UPDATE `tcsinvoicecbt` SET `cbtInvNum`='$invnumcbt',`cbtInvAmt`='$invamtcbt',`cbtInvDate`='$invdatecbt',`cbtInvFile`='$invfilecbt' WHERE `projid`='$prID'";
    $Q0=mysqli_query($conn,$Q) or mysqli_error($conn);

    $Q1="UPDATE `tcsinvoiceresult` SET `resInvNum`='$invnumres',`resInvDate`=' $invdateres',`resInvAmt`='$invamtres',`resInvFile`='$invfileres' WHERE `projid`='$prID'";
    $Q11=mysqli_query($conn,$Q1); 

   
    $Q2="UPDATE `tcspymntstatus` SET `cbtpcnt`='$cbtper',`resultpcnt`='$resper',`cbtpymntamt`='$cbtpymnt',`resultpymntamt`='$respymnt',`cbtInvNum`='$invnumcbt',`resInvNum`='$invnumres',`cbtpymntdone`='$cbtpymntdone',`respymntdone`='$respymntdone' WHERE `tcspymntstatus`.`projid`='$prID'";
    $Q22=mysqli_query($conn,$Q2);

    $Q3="UPDATE `tcsprojectdata` SET `TotalPaymentDone` = '$totpymntdone' WHERE `tcsprojectdata`.`projid` = '$prID' ";
    $Q33=mysqli_query($conn,$Q3);
    if($Q33)
    {
        echo "
        <script>
            alert('Data inserted successfully.');
        </script>
        ";
        ?>
        <meta http-equiv="refresh" content="0; url=project_data1.php">
        <?php
       
    }
    else{
        echo"
        <script>
            alert('Data not inserted');
        </script>
        ";
    }
    
}

    unset($_SESSION['pymnt_sts_updt_aftr1']);
    unset($_SESSION['payment_status_update1']);
    unset($_SESSION['update_pymnt_status1']);
    unset($_SESSION['Project_ID1']);
    unset($_SESSION['ID1']);

?>
