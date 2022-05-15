<?php

   if(!isset($_SESSION))   { 
    session_start(); 
    } 
      if(!isset($_SESSION['$user_logged'])){
    $_SESSION['$user_logged'] = False;
    $_SESSION["loggedin"] = False; 
  }


?>