
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
	
    <?php 
     include("config.php");
     $movie1 =  mysqli_real_escape_string($link, $_GET['movie']);
    echo "<title>" . $movie1 . " - Searched</title>"
    ?>
  </head>
  <?php
  
	$key = 'beefda61';
	// Set parameters & Escapes special characters in a string for use in an SQL statement like NUL (ASCII 0), \n, \r, \, ', ", and Control-Z. 
    $movie1 =  mysqli_real_escape_string($link, $_GET['movie']);
     
	$movie = rawurlencode($movie1);
	
	$uri = 'http://www.omdbapi.com/?apikey=' . $key . '&t=' . $movie;
				
	$response = file_get_contents($uri, true);
	$json_resp = json_decode($response);
?>

  <body>
  
    <div id="container">
  
      <?php
        include 'user_logged.php';
        include 'navbar.php';
	  ?>
	  
	  <?php
			if($json_resp->Response == "False") {
				echo "<h1>Sorry! movie not found</h1>";
				echo "<h1>You can search for another one ..</h1>";
				echo '<form class="search-box" action="search.php" method="GET">';
				echo '<input id="search-bar" class="form-control" type="text" name="movie" placeholder="Search...">';
				echo '<a href="#" class="btn-search">';
				echo '<i class="fas fa-search"></i>';
				echo '</a>';
				echo '</form>';
			}
			else {
				echo '<div class="movie_container">';
				
				echo "<h1>" . $json_resp->Title . " (" . $json_resp->Year . ")<h1>";
				echo "<h2>Rated: " . $json_resp->Rated . "<h2>";
				echo "<h2>Genre: " . $json_resp->Genre . "<h2>";
				echo '<div class="table">';
				echo '<div class="row">';
				echo '<div class="col-sm">';
				echo '<img class="big_poster" src="' . $json_resp->Poster . '" alt="movie poster">';
				echo '</div>';
				echo '<div class="col-sm right-col">';
				echo '<p class="movie_plot">' . $json_resp->Plot . '</p>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				
				if($_SESSION['$user_logged']) {
					
					$u_id = $_SESSION['$user_id'];
					$mv_id = $json_resp->imdbID;
					
				
					$sql = "SELECT * FROM rated_movie WHERE user_id='$u_id' AND movie_id='$mv_id'";
					
					$result = mysqli_query($link, $sql);
					
					if($result) {
					
						if( mysqli_num_rows($result) > 0 ) {
							echo '<p>You already rated this movie!</p>';
						}
						else {
							$mid= $json_resp->imdbID;
							$mt= $json_resp->Title; 
							 ?>
							
							<form action="rating.php" method="POST">
							<input type="hidden" name="MID" value="<?php  echo htmlspecialchars($mid) ;?>">
						    <input type="hidden" name="MT" value="<?php  echo htmlspecialchars( $mt ) ;?>">
							<input class="btn btn_love" type="submit" name="action" value="LOVE">
							<input class="btn btn_hate" type="submit" name="action" value="HATE" >
							</form>
						<?php
						}
					}
				}
				else {
					echo '<p><a href="login.php">Login</a> or <a href="signup.php">Sign up</a> to RATE this movie!';
				}
				
				echo '</div>';
		
			}
			
			 include 'footer.php';
	   ?>
	  
	 
		
    </div>


  </body>
</html>