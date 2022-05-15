<?php

        
		include 'config.php';
		include 'user_logged.php';
		
		$username =$_SESSION['$user_id'] ;

		$mid = $_POST['MID'];

		$movie = $_POST["MT"];

		$vote=$_POST["action"];
	
		$sql = "INSERT INTO rated_movie (vote, movie_id, user_id)   VALUES ('$vote', '$mid', '$username')";

		if (!mysqli_query($link, $sql)) {
		echo "<p>Error: " . $sql . "<br>" . mysql_error($link) . "</p>";
		}
?>

<!DOCTYPE html>
<html>
  <head>
  
  	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/theme.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <?php echo '<title>' . $movie . ' - ' . $vote . '</title>'; ?>
  </head>
  <body>
  
    <div id="container">

      <?php
        include 'user_logged.php';
        include 'navbar.php';
	  ?>
	  
	  <?php 
		echo "<h1>You " . $vote . " " . $movie . '</h1>';
	  ?>
	  
	  <h2>Go to <a href="profile.php">your profile</a></h2>
	  
	  <?php
        include 'footer.php';
      ?>
		
    </div>
  </body>
</html>
