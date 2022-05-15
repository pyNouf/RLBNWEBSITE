<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$signup_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $signup_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $signup_err =  "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
             // Set parameters & Escapes special characters in a string for use in an SQL statement like NUL (ASCII 0), \n, \r, \, ', ", and Control-Z. 
             $param_username=  mysqli_real_escape_string($link, trim($_POST["username"]));
             
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $signup_err = "This username is already taken.";
                } else{
                    $username = mysqli_real_escape_string($link,  trim($_POST["username"]));
                    $email =  mysqli_real_escape_string($link, trim($_POST["email"]));
                }
            } else{
                $signup_err = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $signup_err = "Please enter a password.";     
     } elseif (strlen(trim($_POST["password"])) < 8) {
        $signup_err = "Password too short!";
    }elseif(!preg_match("#[0-9]+#", (trim($_POST["password"])))) {
        $signup_err = "Password must include at least one number!";
    }elseif(!preg_match("#[a-zA-Z]+#", (trim($_POST["password"])))) {
        $signup_err = "Password must include at least one letter!";
    }elseif(!preg_match("/[\'^£$%&*@_#]/" , (trim($_POST["password"])))){
          $signup_err = "Password must contain at least one special character!";
    }else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $signup_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($signup_err) && ($password != $confirm_password)){
            $signup_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($signup_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password,$param_email);
            
            // Set parameters
            $param_username = mysqli_real_escape_string($link, $username);
            $password= mysqli_real_escape_string($link, $password);
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email=  mysqli_real_escape_string($link, $email);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                $signup_err ="Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title> Sign up with us</title>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'>
<link rel="stylesheet" href="login.css">
<meta charset="UTF-8" />
<script type="text/javascript" src="signup.js"></script>

<title>Form Validation</title>

</head>

<!-- partial:index.partial.html -->
<body id="particles-js">
    <?php
    include ("navbar.php");
    ?>
<div class="animated bounceInDown">
  <div class="container">

  <span class="error animated tada" id="msg">   
        
        <?php   if(!empty($signup_err)) {  ?>
        <script>   var msg = document.getElementById('msg');
        msg.style.display = 'block';
         
        </script> 
        
        <?php echo $signup_err;   }  ?>  
      </span>

<br>
    
      <form name="form1" class="box" onsubmit="return checkStuff();" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
      <h1> <a href="index.php"> RLBN </a><span> Movies</span></h1>
      <h3>Create an account </h3>  
    
       <input type="text" name="username" placeholder="Username" autocomplete="off">

        <input type="text" name="email" placeholder="Email" autocomplete="off">

        <i class="typcn typcn-eye" id="eye"></i>
        <input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">
        <i class="typcn typcn-confeye" id="confeye"></i>
        <input type="password" name="confirm_password" placeholder="Confirm Passsword" id="cpwd" autocomplete="off">

    
    
        <br><br>
        <input type="submit" value="Register" class="btn1">
       
    
     <h5> <span > Already have an account? <a href="login.php"> Login here </a> </span> </h5> 
      </form>

  </div> 

</div>

</body>
</html>
