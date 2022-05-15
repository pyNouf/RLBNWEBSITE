<?php
 
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$comment = $name =$posted="";
$comment_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    $comment = mysqli_real_escape_string($link, $_POST["comment"]);
    $name = mysqli_real_escape_string($link,$_POST["name"]);
    /*
 * XSS filter 
 *
 * This was built from numerous sources
 * (thanks all, sorry I didn't track to credit you)
 * 
 * It was tested against *most* exploits here: http://ha.ckers.org/xss.html
 * WARNING: Some weren't tested!!!
 * Those include the Actionscript and SSI samples, or any newer than Jan 2011
 *
 *
 * TO-DO: compare to SymphonyCMS filter:
 * https://github.com/symphonycms/xssfilter/blob/master/extension.driver.php
 * (Symphony's is probably faster than my hack)
 */

function xss_clean( $comment)
{
        // Fix &entity\n;
         $comment  = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'),  $comment );
         $comment  = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;',  $comment );
         $comment  = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;',  $comment );
         $comment  = html_entity_decode( $comment , ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
         $comment  = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>',  $comment );

        // Remove javascript: and vbscript: protocols
         $comment  = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...',  $comment );
         $comment  = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...',  $comment);
         $comment  = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...',  $comment );

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $comment = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $comment);
        $comment = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $comment);
        $comment = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $comment);

        // Remove namespaced elements (we do not need them)
        $comment = preg_replace('#</*\w+:\w[^>]*+>#i', '', $comment);

        do
        {
                // Remove really unwanted tags
                $old_comment = $comment;
                $comment = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $comment);
        }
        while ($old_comment !== $comment);

        // we are done...
        return $comment;
}
    $comment = xss_clean( $comment);
    // Prepare an insert statement
    $sql = "INSERT INTO comment (comment, name) VALUES (?, ?)";
         
     if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_comment, $param_name);
            
            // Set parameters
            $param_comment = $comment;
            $param_name =$name;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $posted="Thank you for your valuable comment!"; 
            } else{
                $comment_err ="Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
   
    

}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title> Leave a Comment</title>
<link rel="stylesheet" href="feedback.css">
<link rel="stylesheet" href="login.css">
<meta charset="UTF-8" />


</head>

<body >



  <?php    
		 
    include 'navbar.php';	
         ?>


<div class="split left">
  <div class="centered">

    <br><br><br><br> <br>
 
      <form id="usrform" name="form" class="box" method="POST" action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
      
      <h2>Leave a Comment </h2>  
    
       <input type="text" name="name" placeholder="Name" autocomplete="off">
      
       <textarea name="comment" form="usrform">Enter text here... </textarea>
        <br><br>
        <input type="submit" value="Post Your Comment" class="btn1">
       
       
        <span class="posted"  style="text-align:center" id="msg">   
        <?php   if(!empty($posted)) {  ?>
        <script>  msg.style.display = 'block';
         </script> 
        
        
        <?php
         echo $posted;
         echo " <br> <br> your comment is: ".''. $_POST["comment"];
           
               }  ?>  
     </span>


      </form>


      </div>
</div>

<div class="split right">
  <div class="adcentered">
      
  <h2>Our User Comments</h2>
   <?php 
               $sql = "SELECT comment , name FROM comment";
				$result = mysqli_query($link, $sql);

				if($result) {
					if(mysqli_num_rows($result) > 0 ) {
						while($row = mysqli_fetch_array($result)) {
					   
              echo '   <hr>';
              echo '<section class="comment">';
              echo ' <p> <strong>';
              echo htmlspecialchars($row['name'] , ENT_QUOTES, 'UTF-8');
              echo  '</strong> </p>';
              echo ' <p>  ';
              echo htmlspecialchars($row['comment'] , ENT_QUOTES, 'UTF-8');
              echo '</p>';
              echo '</section>';
              

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
</div> 



</body>
</html>

