
<?php




// Initialize the session
session_start();
 
// Check if the admin is already logged in, if yes then redirect user to movies.log page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: adminhome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id = $password = "";
$login_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
        $id = trim($_POST["id"]);
        $password = trim($_POST["password"]);
    
    
    // Validate credentials
  
        // Prepare a select statement
        $sql = "SELECT id, password FROM admin WHERE id = ?"; //Good
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["adminID"] = $id;                            
                            
                            // Redirect user to welcome page
                            header("location: adminhome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err ="Invalid id or password."; 
                            
                          
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err ="Invalid id or password."; 


                }
            } else{
                $login_err = "Something went wrong. Please try again later.";
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
var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');

eye.addEventListener('click',togglePass);

function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}

// Form Validation

function checkStuff() {
  var id = document.form1.id;
  var password = document.form1.password;
  var msg = document.getElementById('msg');
  
  if (id.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your adminID";
    id.focus();
    return false;
  } else if (password.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your password";
    password.focus();
    return false; 
  } else {
    msg.innerHTML = "";
  }
   
}
</script>
     
     <link rel="stylesheet" href="login.css">

 

</head>
<body>


    <body id="particles-js"></body>
<div class="animated bounceInDown">
  <div class="container">
      
  <span class="error animated tada" id="msg">   
        
        <?php   if(!empty($login_err)) {  ?>
        <script>  msg.style.display = 'block';
       
        </script> 
        
        <?php echo $login_err;   }  ?>  
      </span>



    <form name="form1" class="box" onsubmit="return checkStuff();" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
    <h1> <a href="index.php"> RLBN </a><span> Movies</span></h1>
      <h3>Admin Account Login </h3>
      
      
      <input type="text" name="id" placeholder="Admin ID" autocomplete="off">


        <i class="typcn typcn-eye" id="eye"></i>
        <input type="password" name="password" placeholder="Passsword" id="pwd" autocomplete="off">

        <label>
          <input type="checkbox">
          <span></span>
          <small class="rmb">Remember me</small>
        </label>


        <br><br>

        <input type="submit" value="Signin" class="btn1">
      </form>



        
  </div> 
    </div>
</body>

</html>