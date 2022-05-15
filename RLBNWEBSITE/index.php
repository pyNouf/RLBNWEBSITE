<!DOCTYPE html>
<html>
  <head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link rel="stylesheet" type="text/css" href="css/theme.css">  
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RLBN Home</title>
  </head>
  <body>

  
    <div id="container">
  
      <?php
        include 'user_logged.php';
        include 'navbar.php';
	  ?>
	  

		  <h1> Search and Rate !</h1>
		  <form class="search-box" action="search.php" method="GET">
			<input id="search-bar" class="form-control" type="text" name="movie" placeholder="Search...">
			<a href="#" class="btn-search">
				<i class="fas fa-search"></i>
			</a>
		  </form>
	
	  
	  <hr class="style13">
	  
	  <h1 class="recent">All Database Recent Ratings</h1>
	  <div class="table">
		<div class="row">
	  <?php
	  
		class MovieStats {
			public $movie_id;
			public $vote_love;
			public $all_votes;
			public function __construct($movie_id){ 
				$this->movie_id = $movie_id;
				$this->vote_love = 0;
				$this->all_votes = 0;
			}
		}
		
		include 'config.php';
		$movie_not_found = False;
		$movie_id_list = array();
		$sql = "SELECT * FROM rated_movie";
		$result = mysqli_query($link, $sql);
		if($result) {
			if(mysqli_num_rows($result) > 0 ) {
				while($row = mysqli_fetch_array($result)) {
					$entered = False;
					foreach ($movie_id_list as $m_key) { 
						if($m_key->movie_id == $row['movie_id']) {
							if($row['vote'] == 'LOVE')
								$m_key->vote_love++;
							$m_key->all_votes++;
							$entered = True;
						}
					}
					if(!$entered){
						$movie_obj = new MovieStats($row['movie_id']);
							if($row['vote'] == 'LOVE')
								$movie_obj->vote_love++;
							$movie_obj->all_votes++;
						array_push($movie_id_list, $movie_obj);
					}
				}
				mysqli_free_result($result);
			}
			else 
				$movie_not_found = True;
			
			function write_movie($movie_id_list, $index) {
				$mv_id = $movie_id_list[$index]->movie_id;
				$stats_perc = ($movie_id_list[$index]->vote_love / $movie_id_list[$index]->all_votes) * 100;
				$stats_perc = round($stats_perc, 2);
				$key = 'beefda61';
				$uri = "http://www.omdbapi.com/?apikey=" . $key . "&i=" . $mv_id;
								
				$response = file_get_contents($uri);
				$json_resp = json_decode($response);
				echo '<h2>' . $json_resp->Title . ' (' . $json_resp->Year . ')</a></h2>';
				echo '<a href="search.php?movie=' . $json_resp->Title . '"><img class="small_poster" alt="movie poster" src="' . $json_resp->Poster . '"></a>';
				if($stats_perc < 70)
					echo '<p><span class="stats_hated">' . $stats_perc . '% liked</span> the movie!</p>'; 
				else 
					echo '<p><span class="stats_loved">' . $stats_perc . '% &#128150</span> the movie!</p>'; 
			}
			
			echo '<div class="col-sm">';
			for ($i = 0; $i < count($movie_id_list); $i += 3) {
				write_movie($movie_id_list, $i);
			}
			echo '</div>';
			
			echo '<div class="col-sm">';
			for ($i = 1; $i < count($movie_id_list); $i += 3) {
				write_movie($movie_id_list, $i);
			}
			echo '</div>';
			
			echo '<div class="col-sm">';
			for ($i = 2; $i < count($movie_id_list); $i += 3) {
				write_movie($movie_id_list, $i);
			}
			echo '</div>';
		}
		else 
			echo "<p>No result from server!<br>Error: " . $result . "</p>";
		
	  ?>
	  
		</div>
        </div>
	  
	  <?php
		if($movie_not_found){
			echo "<h1>There is no movies rated yet!</h1>";}
      
      include 'footer.php'; 
      ?>
        
    
    </div>


  </body>
</html>