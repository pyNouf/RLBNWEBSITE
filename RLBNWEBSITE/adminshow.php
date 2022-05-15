


<?php
session_start();

if (isset($_SESSION['loggedin']) && isset($_SESSION['adminID'])) {

?>

<!DOCTYPE html>

<html>

<head>

    <title>Users Rating</title>

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
           
            th, td {
             padding: 40px;
            border-style: groove;
            
             
                }
                tr:hover {background-color: LightGrey;
                    
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



<h3 class="recent" style="margin:0 auto;text-align:center">All Users Ratings </h3>

<table style="margin:0 auto;text-align:center">
<tr>
<th>User Name</th>
<th>Movie Name</th>
<th>Movie ID</th>
<th>Rateing</th>
  </tr>
<?php

require_once "config.php";


$sql= "SELECT * FROM rated_movie";
$result = $link->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        	$key = 'beefda61';
							$uri = "http://www.omdbapi.com/?apikey=" . $key . "&i=" . $row['movie_id'];
									
							$response = file_get_contents($uri);
							$json_resp = json_decode($response);
						    $b=$json_resp->Title;
							
        echo "<tr><td>" . $row["user_id"]. "</td><td>" . $b."</td><td>" . $row["movie_id"]. " </td><td>" . $row["vote"]. "</td><br>";
    }
    			

} else {
    echo "No results";
}

    mysqli_close($link);

?>


      


        </table>




    

</body>

</html>

<?php 

}else{

     header("Location: adminLogin.php");

     exit();
     

}
      
	
      
      include 'footer.php'; 
    
        


 ?>
