<header>
  
  <?php 
    if($_SESSION['$loggedin'])
      echo "<p>welcome, " . $_SESSION['$username'] "!</p>"; 
  ?>
</header>
