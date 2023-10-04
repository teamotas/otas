<?php
include('connection.php');
error_reporting(0);
// 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['Admin_ID'])) {
    header("location:admin_login.php");
    die();
} else {
    include "sidebar.php";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create | Project</title>
    <link rel="stylesheet" href="css/create.css">
    
</head>
<body>
<div class="container">
    <h2>Select Client</h2>
    <div class="chooseclient">
    <form action="create_project.php" method="Post" onsubmit="return validateForm()">

<label for="chooseClient" class="label">Select Client to Create Project<sup>*</sup></label>
<select name="Id" id="chooseClient" required>
    <option value='' selected>--Select Client--</option>
    <?php 
    $Q2 = "SELECT * from client ";
    $q11 = mysqli_query($conn, $Q2);
    while ($q01 = mysqli_fetch_assoc($q11)) : ?>
        <option value="<?php echo $q01['ClientId'];   ?>" data-clientid="<?php echo $q01['ClientId']; ?>"><?php echo $q01['ClientName']; ?></option>
         
    <?php endwhile; ?>
    <div class="error"></div>
</select>
<div>
    <span style="display:inline-flex; color:red; font-size:1.4rem;"><sup>*</sup>Select client</span>
</div> 
<input type="hidden" name="selectedClient" id="selectedClient" value="">

<input type="submit" value="Select" class="loginbtn" name="chooseclient">
</form>
<script>
function validateForm() {
    var clientSelect = document.getElementById("chooseClient");
    var selectedOption = clientSelect.options[clientSelect.selectedIndex];
    var selectedClientId = selectedOption.getAttribute("data-clientid");

    if (selectedClientId === "") {
        alert("Please select a Client.");
        return false;
    }
// Set the selected client ID as the value of the hidden input field
document.getElementById("selectedClient").value = selectedClientId;
    return true;
    // // Update the form action with the selected client ID//
    // var form = document.querySelector("form");
    // form.action = "create_project.php?client_id=" + selectedClientId;

    
      
            // var role = document.getElementById("chooseClient").value;
            // if (role == "") {
            //     alert("Please select a Client.");
            //     return false;
            // }
            // return true;
        }

        // JavaScript code to check and redirect if no clients found
        document.addEventListener("DOMContentLoaded", function() {
            var clientSelect = document.getElementById("chooseClient");
            if (clientSelect.length <= 1) {
                window.location.href = "create_client.php";
            }
        });
</script>
</div>
</div>
</body>
</html>
