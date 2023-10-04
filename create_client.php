<?php
include('connection.php');
error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['Admin_ID'])) {
	header("location:admin_login.php");
	die();
}
else{
    include "sidebar.php";
  }

// if (!isset($_SESSION['Employee_ID'])) {
// 	header("location:login.php");
// 	die();
// }
// else{
//     include "sidebar.php";
//   }
$country = "SELECT * FROM countries";
$county_qry = mysqli_query($conn, $country);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="photos\images.png"/>
    <title>Create | Client</title>
    <link rel="stylesheet" href="css\create.css">
    <!-- <link rel="stylesheet" href=".css"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> 
    <script>
       
    </script>
</head>
<body>
    <form action="#" method="POST" onsubmit="return validateForm()">
    <div class='container1'>
        <h2>Create Client</h2>
        <div >
            <label for="clientName" class="label">Client Name<sup>*</sup></label>
            <input type="text" id='clientName' name='clientName' required>
        </div>
        <div class="">
        <label for="country" class="label">Country<sup>*</sup></label>
                    <select class="selectfont" id="country" name="country" required>
                        <option selected disabled value='' required>--Select Country--</option>
                        <?php while ($row = mysqli_fetch_assoc($county_qry)) : ?>
                            <option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?> </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="">
                <label for="state" class="label">State<sup>*</sup></label>
                    <select class="selectfont" id="state" name='state'>
                        <option selected disabled>--Select State--</option>
                    </select>
                </div>
                <div class="">
                <label for="city"  class="label">City <!--HeadQuarter --><sup>*</sup></label>
                    <select class="selectfont" id="city" name="city" >
                        <option selected disabled>--Select City--</option>
                        <option value="other">Other City</option>
                    </select>
                </div>
                <div>
                <label for="otherCityInput" class="label" style="display: none;">Other City</label>
                <input type="text" id="otherCityInput" name="otherCity" style="display: none;">
                </div>
                <div>
                <span style="color:red; font-size:1.4rem;"><sup>*</sup>All fields are mandatory</span>
               </div>
        <div>
            <button name='createClient' class='loginbtn1'>Create</button>
        </div>
    </div>
  

<script>
   $(document).ready(function() {
        $('#city').on('change', function() {
            var selectedCity = this.value;
            if (selectedCity === 'other') {
                // If "Other City" is selected, show both the label and input field
                $('#otherCityInput').show();
                $('label[for="otherCityInput"]').show();
            } else {
                // If a city is selected, hide both the label and input field
                $('#otherCityInput').hide();
                $('label[for="otherCityInput"]').hide();
            }
        });
    });
        document.addEventListener("DOMContentLoaded", function() {
    var projectNameInput = document.getElementById("clientName");

    projectNameInput.addEventListener("input", function() {
        this.value = this.value.toUpperCase();
    });
});


        function validateForm() {
            var role = document.getElementById("country").value;
            var role1 = document.getElementById("state").value;
            var role2 = document.getElementById("city").value;
            if (role == "") {
            alert("Please Select Country.");
            return false;
            }
            if (role1 == "") {
            alert("Please Select State.");
            return false;
            }
            if (role2 == "") {
            alert("Please Select City.");
            return false;
            }
         return true;
        }
        </script>
    </form>

</body>
</html>
<script>


    // Country State

    $('#country').on('change', function() {

        var country_id = this.value;
        // console.log(country_id);
        $.ajax({
            url: 'state.php',
            type: "POST",
            data: {
                country_data: country_id
            },
            success: function(result) {
                $('#state').html(result);
                // console.log(result);
            }
        })
    });
    // state city
    $('#state').on('change', function() {
       
        var state_id = this.value;
        // console.log(country_id);
        $.ajax({
            url: 'city.php',
            type: "POST",
            data: {
                state_data: state_id
            },
            success: function(data) {
                $('#city').html(data);
                // console.log(data);
            }
        })
    });
</script>

<?php
// create client Id

if (isset($_POST['createClient'])) {
    $clientName = mysqli_real_escape_string($conn, $_POST['clientName']);
    $selectedCity = mysqli_real_escape_string($conn, $_POST['city']);
    $otherCity = mysqli_real_escape_string($conn, $_POST['otherCity']);
    $selectedStateId=mysqli_real_escape_string($conn,$_POST['state']);
    
    if ($selectedCity === 'other' && !empty($otherCity)) {
        // Fetch the last city ID
        $lastCityIdQuery = "SELECT id FROM `city` ORDER BY `id` DESC LIMIT 1";
        $lastCityIdResult = mysqli_query($conn, $lastCityIdQuery);
        
        if ($lastCityIdResult && $row = mysqli_fetch_assoc($lastCityIdResult)) {
            $lastid = $row['id'] + 1;
            // Insert the new city into the database
            $insertCityQuery = "INSERT INTO `city` (`id`, `name`, `state_id`) VALUES ('$lastid', '$otherCity', '$selectedStateId')";
            $insertCityResult = mysqli_query($conn, $insertCityQuery);
            
            if ($insertCityResult) {
                // Get the ID of the newly inserted city
                $newCityId = $lastid;
                $cityId = $newCityId;
            } else {
                // Handle the error if the city insertion fails
                echo "<script>alert('Failed to add new city to the database.');</script>";
            }
        } else {
            // Handle the error if fetching the last city ID fails
            echo "<script>alert('Failed to retrieve the last city ID.');</script>";
        }
    } else {
        // Use the selected city from the dropdown
        $cityId = $selectedCity;
    }
    
    $checkid="SELECT * FROM `client` ORDER BY `ClientId` DESC LIMIT 1";
    $checkresultid=mysqli_query($conn,$checkid);
    
    if(mysqli_num_rows($checkresultid)>0){
      if($row=mysqli_fetch_assoc($checkresultid)){
        $did=$row['ClientId'];
        $get_numbers=str_replace("CL","",$did);
        $id_increase=$get_numbers+1;
        $get_string=str_pad($id_increase,6,0,STR_PAD_LEFT);
        $clientId="CL" . $get_string;
        $query3="INSERT INTO `client`(`ClientId`, `ClientName`, `CityId`) VALUES('$clientId','$clientName','$cityId')";
    
        $noquery3=mysqli_query($conn,$query3) or die('Failed'.mysqli_error($conn));
      
        if($noquery3){
          $_SESSION['Client_ID']=$clientId;
          echo"
          <script>
          alert(' New Entry Added.\\n Name: $clientName \\n Client Id : $clientId');
          location.replace('create_project.php');
          </script> 
          ";
        } else{
          echo"<script>
          alert('Record not inserted.');
          </script>";
        }}
    }
    else{
      $clientId="CL000001";
      $insrtclientdetails= "INSERT INTO client (ClientId,ClientName,CityId) VALUES ('$clientId','$clientName','$cityId')";
      $result=mysqli_query($conn,$insrtclientdetails);
      if($result){
        $_SESSION['Client_ID']=$clientId;
        echo"
        <script>
        alert(' New Entry Added.\\n Name: $clientName \\n Client Id : $clientId');
        location.replace('create_project.php');
        </script> 
        ";
      
      }
      else{
        echo"<script>
        alert('Record not inserted.');
        </script>";
      }
    }
    }
    
    ?>