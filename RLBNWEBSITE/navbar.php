<!DOCTYPE html>
<html lang="en">
  <head>
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
        </style>
  </head> 
  <body>	
		<section class="section section--menu" id="ABC">
			<h2 class="section__title" style="color:#111213">Movie Rating Website</h2>
			<img class="logo" alt="logo" src="images/logo.png" width="100" height="100">
			<nav class="menu menu--iris">
				<ul id="navbar_up" class="menu__list">
					<li class="menu__item"><a href="index.php" class="menu__link" style="color:#111213">Home</a></li>
					<li class="menu__item"><a href="feedback.php" class="menu__link" style="color:#111213">Feedback</a></li>
						<li class="menu__item"><a href="aboutus.php" class="menu__link" style="color:#111213">About us</a></li>
					<?php 
                         include 'user_logged.php';

						if($_SESSION['$user_logged']) { 
							echo '<li class="menu__item"><a class="menu__link" href="profile.php" style="color:#111213">' . 
							$_SESSION['$user_id'] . ' Profile</a></li>'; 
							echo '<li class="menu__item"><a class="menu__link" href="signout.php" style="color:#111213">Sign Out</a></li>'; 
						} 
						else { 
							?> <li class="menu__item"><a class="menu__link" href="login.php" style="color:#111213">Login</a></li>
							<li class="menu__item"><a class="menu__link" href="signup.php" style="color:#111213">Sign up</a></li> 
							<?php
						} 
					?> 
					
				</ul>
			</nav>
		</section>
	
  </body>
</html>