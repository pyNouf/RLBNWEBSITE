<?php

// INSERT INTO `user` (`username`, `email`, `password`) VALUES ('Test', 'Test@hotmail.com', 'MyFYTa9bLqWhs');



// Initialize the session
session_start();
 
 
// Check if the user is already logged in, if yes then redirect user to movies.log page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = "";
$forget_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
        $username = trim($_POST["username"]);
        $email=trim($_POST["email"]); 
   
    
    
    // Validate credentials
  
        // Prepare a select statement
        $sql = " SELECT username ,email FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,"s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){  

                  // Bind result variables 
                  mysqli_stmt_bind_result($stmt, $username, $emaildb);
                  if (mysqli_stmt_fetch($stmt)){

                    if ($email===$emaildb)  {
                      $_SESSION['username']=$username;
                      header('location: UpdatePassword.php');      
                    }      
              
                      else{ 
  
                        // Email dosen't match, display a generic error message
                        $forget_err ="Credintial you prodvided are wrong or dosent exist!"; 
                      }
    
                  }

                

                }
                
                else{ 

                  // Username doesn't exist, display a generic error message
                  $forget_err ="ssssCredintial you prodvided are wrong or dosent exist!"; 
                }


            } else{
                $forger_err ="Something went wrong. Please try again later."; 
                }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    
    
    // Close connection
    mysqli_close($link);
    

}
?>
 
<!DOCTYPE html>
<html>

    <head>
        <title> </title>
        <meta charset="utf-8">
   

     <script type="text/javascript">



// Form Validation

function checkStuff() {
  var username = document.form1.username;
  var email = document.form1.email;
  var msg = document.getElementById('msg');
  
  if (username.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your username";
    username.focus();

    return false;
  }
  else if  (email.value == "") {
      msg.style.display = 'block';
      msg.innerHTML = "Please enter your email";
      email.focus();
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
            <?php
    include ("navbar.php");
    ?>
<div class="animated bounceInDown">
  <div class="container">
      
    <span class="error animated tada" id="msg">   
        
        <?php   if(!empty($forget_err)) {  ?>
        <script>  msg.style.display = 'block';
        
        </script> 
        
        <?php echo $forget_err;   }  ?>  
      </span>



      <form name="form1" class="box" onsubmit="return checkStuff();" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
      <h1> <a href="index.php"> RLBN </a><span> Movies</span></h1>
      <h3> Forget your password</h3>
      
      <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">

      <input type="text" name="email" id="email" placeholder="Email" autocomplete="off">

      <input type="submit" value="Forget password" class="btn1" action>
    
        
        <h5> <span> Don’t have an account? <a href="signup.php" > Sign up</a> </span> </h5> 
        <h5 id="two"> <span> Already have an account? <a href="login.php" > Login </a> </span> </h5> 
        
        
      </form>

  </div> 
     
</div>
</body>

</html>