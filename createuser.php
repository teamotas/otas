<?php
require('connection.php');

session_start();
error_reporting(0);
$errors = array();
if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();
}
else{
  include "sidebar.php";
}

// if (!isset($_SESSION['Employee_ID'])) {
// 	header("location:index.php");
// 	die();
// }
// else{
//   include "sidebar.php";
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create | User</title>
    <link rel="stylesheet" href="css/create.css">
    <!-- <link rel="icon" type="image/png" href="photos\images.png"/>  -->
    <script src="js/cript1.js"></script>
    <style>
    
    </style>
</head>
<body>

    <div class="container">
        <form action="#" method="post" autocomplete="off" enctype="application/x-www-form-urlencoded" onsubmit="return validateForm();">
            <?php include('errors.php'); ?>
            <div class="heading">
                <h2>Create User</h2>
            </div>
            <div class="">
                <label for="name" class="label">Name <sup>*</sup></label>
                <input type="text" name="Name" id="name" required autocomplete="off"
                placeholder="Enter Name">
                
            </div>
            
            <div class="">
                <label for="email" class="label">Email Id<sup>*</sup></label>
                <input type="email" name="EmailId" id="email" required autocomplete="off"
                
                placeholder="@edcil.co.in">
            </div>
            <div class="">
                <label for="empid" class="label">Employee Id<sup>*</sup></label>
                <input type="text" name="EmployeeId" id="empid" required autocomplete="off" placeholder="Enter Employee Id ">
            </div>
            <div class="">
                <label for="profilename" class="label">Designation<sup>*</sup></label>
                <input type="text" name="Designation" id="profilename" autocomplete="off" placeholder="Enter Designation" required>
            </div>
            <div class=" space" >
                <span>
                <label for="userrole" class="label">User Role :</label>
                <select id="userrole" name="UserRole" value='Not Selected'  autocomplete="off">
                <option value  selected>Select</option>
                <option value="Read">Read</option>
                <option value="Write">Write</option>
                <option value="Read & Write">Read & Write</option>
                </select>
                </span>
                <span class="moveside">
                <label for="department" class="label">Department<sup>*</sup> :</label>
                <select id="department" name="Department" required autocomplete="off">
                <option value disabled selected>Select</option>
                <option value='OTAS'>OTAS</option>
                <!-- <option value='DES' disabled>DES</option>
                <option value='EIS|EPS' disabled>EIS|EPS</option> -->
                </select>
                </span>
            </div>
            
            <div class="Gender"><span class="label">Gender<sup>*</sup>:</span> 
            <input type="radio" name="Gender" id="male" value="Male" autocomplete="off" class="" >
            <label for="male" >&nbsp;Male</label>
            <input type="radio" name="Gender" id="female" value="Female" autocomplete="off" class="">
            <label for="female" >&nbsp;Female</label>
            </div>
            <div class="">
                <label for="dob" class="label">Date Of Birth</label>
                <input type="date" name="DateOfBirth" id="dob"  autocomplete="off" placeholder="Select Date Of Birth">
            </div>
            
            <div class="">
                <label for="mobile" class="label">Mobile No<sup>*</sup></label>
                <input type="tel" name="MobileNo" id="mobile" maxlength="10" required autocomplete="off" 
                
                placeholder="Enter Mobile Number">
            </div>
<!-- pattern="[6-9]{3}-[0-9]{3}-[0-9]{4}" -->
            <div class="">
                <label for="pswd" class="label">Password<sup>*</sup>
                <div class="info-icon">
                <i class='bx bx-error-circle'></i>
                <div class="tooltip">
                  <p>Password must contain:</p>
                  <ul>
                    <li>At least 8 characters</li>
                    <li>At least one uppercase letter</li>
                    <li>At least one number</li>
                    <li>At least one special character</li>
                  </ul>
                </div>
              </div>
             </label>
                <input type="password" name="Password" id="pswd" autocomplete="off"
                placeholder="Enter Password">
            </div>
            <div class="">
                <label for="pswd" class="label">Confirm Password<sup>*</sup></label>
                <input type="password" name="ConfirmPassword" id="pswd1" autocomplete="off"
               placeholder="Enter Confirm Password">
              
               <div class='showpswd'>
               <input type="checkbox" id="showpswd" onclick="myFunction()">&nbsp;<label for="showpswd"  class="label" style="font-size: 1.6rem;">Show Password</label>
               </div>
              
               <div>
                <span style="color:red; font-size:1.4rem;"><sup>*</sup>All fields are mandatory</span>
               </div>
            </div>
            <button type="submit" class="loginbtn" name="create">Create</button>
            
        </form>
    </div>
</body>

</html>
<?php
// Create User
if(isset($_POST['create'])){
    // receive all input values from the form\
    // $imagepath="photos\default_image.jpeg";
     $Name= mysqli_real_escape_string($conn,$_POST['Name']);
     $EmailId= mysqli_real_escape_string($conn,$_POST['EmailId']);
     $EmployeeId= mysqli_real_escape_string($conn,$_POST['EmployeeId']);
     $UserRole= mysqli_real_escape_string($conn,$_POST['UserRole']);
     $Department= mysqli_real_escape_string($conn,$_POST['Department']);
     $Designation= mysqli_real_escape_string($conn,$_POST['Designation']);
     $MobileNo= mysqli_real_escape_string($conn,$_POST['MobileNo']);
     $DateOfBirth= mysqli_real_escape_string($conn,$_POST['DateOfBirth']);
     $Gender= mysqli_real_escape_string($conn,$_POST['Gender']);
     $Password=mysqli_real_escape_string($conn,$_POST['Password']);
     $ConfirmPassword=mysqli_real_escape_string($conn,$_POST['ConfirmPassword']);
     
 
     // form validation: ensure that the form is correctly filled ...
     // by adding (array_push()) corresponding error unto $errors array
    //  if (empty($Name)) { array_push($errors, "Name is required"); }
    //  if (empty($EmailId)) { array_push($errors, "Email is required"); }
    //  if (empty($EmployeeId)) { array_push($errors, "EmployeeId is required"); }
    // //  if (empty($UserRole)) { array_push($errors, "UserRole is required"); }
    //  if (empty($Department)) { array_push($errors, "Department is required"); }
    //  if (empty($Designation)) { array_push($errors, "Designation is required"); }
    //  if (empty($MobileNo)) { array_push($errors, "MobileNo is required"); }
    //  if (empty($DateOfBirth)) { array_push($errors, "DateOfBirth is required"); }
    //  if (empty($Gender)) { array_push($errors, "Gender is required"); }
    //  if (empty($Password)) { array_push($errors, "Password is required"); }
    //  if (empty($ConfirmPassword)) { array_push($errors, "Confirm Password required"); }
      
    
     // first check the database to make sure 
     // a user does not already exist with the same employeeid and/or email
     $user_check_query = "SELECT * FROM employee WHERE EmployeeId='$EmployeeId' OR EmailId='$EmailId' LIMIT 1";
 
     $result = mysqli_query($conn, $user_check_query);
     $user = mysqli_fetch_assoc($result);
 
    if ($user['EmployeeId'] === $EmployeeId || $user['EmailId'] === $EmailId) {
    //  array_push($errors, "User already exists");
      echo"<script>
      alert('User already exists.');
      </script>";
      ?>
      <meta http-equiv="refresh" content="0;  URL=index.php" />
      <?php
       }
    else{
        // Finally, register user if there are no errors in the form
   if (count($errors) == 0) {
    $encpswd=password_hash($Password,PASSWORD_DEFAULT);//encrypt the password
    // Generate a unique reset token
    // $Token = bin2hex(random_bytes(32));
    $Usertype='User';
    $query = "INSERT INTO employee (Name,EmailId,EmployeeId,Designation,MobileNo,DateOfBirth,Gender,EmployeeType,Password) VALUES ('$Name','$EmailId','$EmployeeId','$Designation','$MobileNo','$DateOfBirth','$Gender','$Usertype','$encpswd')";
    $noquery=mysqli_query($conn,$query) or die('Query is failed'.mysqli_error($conn));

    if($noquery==1){
      $query2="INSERT INTO roles(EmployeeId,UserRole) VALUES('$EmployeeId','$UserRole')";
      $noquery2=mysqli_query($conn,$query2) or die('Query2 is failed'.mysqli_error($conn));
      
      if($noquery2==1){
        // if($Department=='OTAS'){
        $checkid="SELECT * FROM `department` ORDER BY `DepartmentId` DESC LIMIT 1";
        $checkresultid=mysqli_query($conn,$checkid);
        if(mysqli_num_rows($checkresultid)>0){
          if($row=mysqli_fetch_assoc($checkresultid)){
            $did=$row['DepartmentId'];
            $get_numbers=str_replace("OTAS","",$did);
            $id_increase=$get_numbers+1;
            $get_string=str_pad($id_increase,5,0,STR_PAD_LEFT);
            $DepartmentId="OTAS" . $get_string;
            
            $query3="INSERT INTO `department`(`DepartmentName`, `DepartmentId`, `EmployeeId`) VALUES('$Department','$DepartmentId','$EmployeeId')";
            $noquery3=mysqli_query($conn,$query3) or die('Query3 is failed'.mysqli_error($conn));
            
            if($noquery3){
              echo"
              <script>
              alert(' New Entry Added.\\n Name: $Name \\n Department Id : $DepartmentId');
              location.replace('userdata.php');
              </script> 
              ";
            }
            else{
              echo"<script>
              alert('Record not inserted.');
              </script>";
            }}
          // }
        }
        else{
          $DepartmentId="OTAS00001";
          $query3="INSERT INTO department(`DepartmentName`, `DepartmentId`, `EmployeeId`) VALUES('$Department','$DepartmentId','$EmployeeId')";
          $noquery3=mysqli_query($conn,$query3) or die('Query3 is failed'.mysqli_error($conn));

          if($noquery3){
              echo"
              <script>
              alert(' New Entry Added.\\n Name: $Name\\n Department Id : $DepartmentId');
              </script> 
              ";
              ?>
              <meta http-equiv="refresh" content="0;  URL=userdata.php" />
              <?php
            }
            else{
              echo"<script>
              alert('Record not inserted.');
              </script>";
            }
          
          }
        
      }
      
    }else{
      echo"<script>
              alert('Something Gone Wrong......\\nTry Again...');
              </script>";
    }

    mysqli_close($conn);
    }
    }
   }
?>