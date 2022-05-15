


<?php
session_start();

if (isset($_SESSION['loggedin']) && isset($_SESSION['adminID'])) {

?>

<!DOCTYPE html>

<html>

<head>

    <title>HOME</title>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" type="text/css" href="css/demo.css">
	<link rel="stylesheet" type="text/css" href="css/theme.css"> 
	<link rel="stylesheet" type="text/css" href="css/component.css">
	<link rel="stylesheet" href="login.css">
      <style>
            #ABC {
                background-color:#BFDCF3;
                height: 30%;
            }
        </style>
   
    
</head>

<body>
	<div id="container">  

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

    <h2 style="margin:0 auto;text-align:center">Hello admin </h2>

     <!-- <a href="adminLogout.php">Logout</a> -->
    <br>
     <br>
      <br>
       <br>
        <br>
         <br>
          <br>
           <br>
            <br>
             <br><br>
      <br>
       <br>
        <br>
         <br>
          <br>
           <br>
            <br>
             <br>
              <br>
              <br>
    <br>
       <br>
        <br>
         <br>
          <br>

<?php 
  
      include 'footer.php'; 
    
?>
</div>
</body>

</html>

<?php 

}else{

     header("Location: adminLogin.php");

     exit();
     

}
      
	
        


 ?>