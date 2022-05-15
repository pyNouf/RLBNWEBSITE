<?php

// INSERT INTO `user` (`username`, `email`, `password`) VALUES ('Test', 'Test@hotmail.com', 'MyFYTa9bLqWhs');

session_start();

// Initialize the session

 
// Check if the user is already logged in, if yes then redirect user to movies.log page
if(!isset($_SESSION["username"])){
    header("location: ForgotPassword.php");
    exit;
}
 
// Include config file
require_once "config.php";


// Define variables and initialize with empty values
$password = $confirm_password = "";
$update_err = "";
$username= $_SESSION['username'] ;
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    
    if(empty(trim($_POST["password"]))){
        $update_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $update_err ="Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $update_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($update_err) && ($password != $confirm_password)){
            $update_err = "Password did not match.";
        }
    }
    
    if(empty($update_err) ){
        
        // Prepare an insert statement
        $sql = "UPDATE user SET password=? WHERE username=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password,$param_username);
            // Set new Pass
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_username= $username;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } 
            else{
                $update_err ="Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    
      
    // Close connection
    mysqli_close($link);
    

}
}
?>
 
<!DOCTYPE html>
<html>

    <head>
        <title> </title>
        <meta charset="utf-8">
   

    <script type="text/javascript">


var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');
var confeye = document.getElementById('confeye');
eye.addEventListener('click',togglePass);
var cpwd = document.getElementById('cpwd');



function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}
function togglePass(){

confeye.classList.toggle('active');

(cpwd.type == 'password') ? cpwd.type = 'text' : cpwd.type = 'password';
}
// Form Validation

function checkStuff() {
    var password = document.form1.password;
    var cpassword = document.form1.confirm_password;

    var msg = document.getElementById('msg');
  
    if (password.value == "") {
        msg.innerHTML = "Please enter your password";
        password.focus();
        return false;
    } 
    else {
        msg.innerHTML = "";
    }
    if (cpassword.value == "") {
        msg.innerHTML = "Please enter your password";
        cpassword.focus();
        return false;
    } 
    else {
        msg.innerHTML = "";
    }
    if (password.value != cpassword.value) {
        msg.style.display = 'block';
        msg.innerHTML = "passwords doesn't match";
        cpassword.focus();
        password.focus();
        return false;
    } 
    else {
        msg.innerHTML = "";
    } 


   
} 
    </script>
     
    <link rel="stylesheet" href="login.css">
    
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'>

 

</head>


    <body id="particles-js">
 
<div class="animated bounceInDown">
  <div class="container">
      
    <span class="error animated tada" id="msg">   
        
        <?php   if(!empty($update_err)) {  ?>
        <script>  msg.style.display = 'block';
        
        </script> 
        
        <?php echo $update_err;   }  ?>  
      </span>



    <form name="form1" class="box" onsubmit="return checkStuff();" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
    <h1> <a href="index.php"> RLBN </a><span> Movies</span></h1>
    <h3> Reset your passowrd</h3>
      
      
    <i class="typcn typcn-eye" id="eye"></i>
    <input type="password" name="password" placeholder="New Passsword" id="pwd" autocomplete="off">
    <i class="typcn typcn-confeye" id="confeye"></i>
    <input type="password" name="confirm_password" placeholder="Confirm Passsword" id="cpwd" autocomplete="off">


 
    

    <input type="submit" value="Reset password" class="btn1" action>
    <br><br><br><br><br><br> <br>
        
        
    </form>

  </div> 
     
</div>
</body>

</html>