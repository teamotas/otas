<?php
// session_start();
require_once('connection.php');
$token=$_GET['token'];
$id=$_GET['emid'];
if($token && $id){

}
else{
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create | Password</title>
    <link rel="stylesheet" href="css/pass.css">
    <link rel="icon" type="image/png" href="photos\images.png"/>
    <script src="js/cript1.js"></script>
</head>
<body>
    <div class='Passbox'>
        <div>
            <h2>Create New Password</h2>
            <!-- <span>&times;</span> -->
        </div>
        <form action="#" method="POST" enctype="application/x-www-form-urlencoded" onsubmit="return validateForm3();">
            <div class="">
                <label for="pswd" class="label">New Password</label>
                <input type="passwsubmitord" name="Password" class="input" id='pswd' autocomplete="off"
                placeholder="Enter Password">
            </div>
            <div class="">
                <label for="pswd" class="label">Confirm Password</label>
                <input type="password" name="ConfirmPassword" class="input" id='pswd1' autocomplete="off"
                placeholder="Enter Confirm Password">
            </div>
            <div class="centre">
                <input type="checkbox" onclick="myFunction()" id="showpswd">&nbsp;<label for="showpswd" >Show Password</label>
            </div>
            <div>
                <input type="submit" value='Update' name='create'>
               
            </div>
           
        </form>
    </div>
</body>
</html>
<?php
require_once 'connection.php';

if(isset($_POST['create'])){
    if(isset($_GET['token'])){
        if(isset($_GET['emid']))
        {  
            $done="SELECT * from employee where EmployeeId='$id' AND token='$token'";
            $doneq=mysqli_query($conn,$done);
            if(mysqli_num_rows($doneq) >0){
                $Password=mysqli_real_escape_string($conn,$_POST['Password']);
                $ConfirmPassword=mysqli_real_escape_string($conn,$_POST['ConfirmPassword']);
                
                if (empty($Password)) { array_push($errors, "Password is required"); }
                if (empty($ConfirmPassword)) { array_push($errors, "Confirm Password required"); }
                if ($Password === $ConfirmPassword) {
                    $Password=$ConfirmPassword;
                    if (count($errors) == 0) {
                        $encpswd=password_hash($Password,PASSWORD_DEFAULT);//encrypt the password
                        $Q="UPDATE employee set Password='$encpswd', token='0' where EmployeeId='$id'";
                        $Q2=mysqli_query($conn,$Q);
                        if($Q2){
                            echo"
                            <script>
                            alert('Password Updated.');
                            location.replace('login.php');
                            </script>
                            " ;
                            // header('Location:login.php');
                        }
                        else{
                            echo"
                                <script>
                                alert('Password Not Updated.');
                                </script>
                                ";
                        }
                    }
                }
            }else{
                echo"
                    <script>
                    alert('Link Expired.');
                    location.replace('login.php');
                    </script>
                    ";
            }
        }
            else{
                echo"
            <script>
            alert('ID Not Found.');
            </script>
            ";
            }
            
    }else{
        echo"
            <script>
            alert('Token Not Found.');
            </script>
            ";
    }
}
?>