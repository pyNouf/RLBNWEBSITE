
<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>Received Feedback </title>
<link rel="stylesheet" href="feedback.css">
<link rel="stylesheet" href="login.css">
	<link rel="stylesheet" type="text/css" href="css/demo.css">
	<link rel="stylesheet" type="text/css" href="css/theme.css"> 
	<link rel="stylesheet" type="text/css" href="css/component.css">

<meta charset="UTF-8" />


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



      <h2>We Received the follwing comments </h2>  
        <hr>

   <div id="adcentered"> 
   <?php 
             // Include config file
              require_once "config.php";

               $sql = "SELECT comment , name FROM comment";
				$result = mysqli_query($link, $sql);

				if($result) {
					if(mysqli_num_rows($result) > 0 ) {
						while($row = mysqli_fetch_array($result)) {
			
              echo '<section class="comment">';

              echo ' <p> <strong>';
              echo htmlspecialchars($row['name']  , ENT_QUOTES, 'UTF-8');
              echo  '</strong> </p>';
              echo ' <p>  ';
              echo htmlspecialchars($row['comment'] , ENT_QUOTES, 'UTF-8'); 
              echo '</p>';
              echo '</section>';
              		   
              echo '   <hr>';

						}
          
						mysqli_free_result($result);
					}

					else {
						echo "<h2>No Comments yet!</h2>";
					}
        }
    // Close connection
    mysqli_close($link);
          ?> 
          
             
      </div>          

<?php 
  
      include 'footer.php'; 
    
?>
</div>
</body>

</html>

