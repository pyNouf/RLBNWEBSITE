

<?php
session_start();

if (isset($_SESSION['loggedin']) && isset($_SESSION['adminID'])) {

    include_once 'config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
       
        $username =mysqli_real_escape_string($link, trim($_POST["username"]));
        $movieid =mysqli_real_escape_string($link,trim($_POST["movieid"]));
        
        
        $sql = "DELETE FROM rated_movie WHERE user_id=? AND movie_id=?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt,"ss",$_POST["username"],$_POST["movieid"]);
            mysqli_stmt_execute($stmt);
         
            if (mysqli_affected_rows($link) > 0){
             
            echo '<script>alert("User Rating deleted successfully")</script>';
        }
        else {
            echo '<script>alert("Record does not exist:")</script>' . mysqli_error($link);
        }
                 

    mysqli_close($link);
    }
    else
    {
                    echo '<script>alert("Wrong Entery")</script>';

        
    }
    
            
              
}
            
        
}else{

     header("Location: adminLogin.php");
     exit();
     
}
?>
<!DOCTYPE html>

<html>

<head>

    <title>Delete Rating</title>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/demo.css">
	<link rel="stylesheet" type="text/css" href="css/component.css">
	<link rel="stylesheet" href="login.css">
      <style>
            #ABC {
                background-color:#BFDCF3;
            
            }
         .container{
  margin: 0;
  top: 200px;
  left: 50%;
  position: absolute;
  text-align: center;
  transform: translateX(-50%);
  background-color:rgba(88, 88, 88, 0.4);
  border-radius: 9px;
  width: 400px;
  height: 600PX;
}
 
        </style>
         
   
</head>

<body>


     <section class="section section--menu" id="ABC" >
        <h2 class="section__title" style="color:#111213">Movie Rating Website</h2>
			<img class="logo" alt="logo" src="images/logo.png" width="100" height="100">
			<nav class="menu menu--iris">
                <ul id="navbar_up" class="menu__list">

                <li class="menu__item"><a href="adminhome.php" class="menu__link" style="color:#111213">Home</a></li>

                <li class="menu__item"><a class="menu__link" href="adminshow.php" style="color:#111213">Show Rating</a></li>
                <li class="menu__item"><a class="menu__link" href="admindelete.php" style="color:#111213">Delete Rating</a></li>
                  <li class="menu__item"><a class="menu__link" href="adminfeedback.php" style="color:#111213">Users Feedback</a></li>
                <li class="menu__item"><a class="menu__link" href="adminLogout.php" style="color:#111213">Sign Out</a></li>
            

               
            </ul>
        </nav>
    </section>
    
     

    <body id="particles-js"></body>
<div class="animated bounceInDown">
 <div class="container">
     

        <form method="POST" name="form1" class="box" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1> <a href="index.php"> RLBN </a><span> Movies</span></h1>
            <h3 class="recent" style="margin:0 auto;text-align:center">Delete Rataing </h3>
            <br> <br> <br>
                <label> Enter username :</label>
                <input type="text" name="username" placeholder="username">
           
                <label> Enter ID of the movie :</label>
                <input type="text" name="movieid" placeholder="movie ID"> 
         
                <input type="submit" value="Delete" class="btn1" action>
        </form>

  </div> 
   
</div>


 
</body>

</html>

