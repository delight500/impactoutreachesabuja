<?php
if(!isset($_SESSION)) { session_start();} 
/* Start session, this is necessary, it must be the first thing in the PHP document after <?php syntax ! */ 
        
/* Full membership with login and registration
 * PHP script that includes login registration form with proper password salting, login form with validation and
   

/* Require login.php to call login function */
require("classes/UserClass.php");

/* Call for login function */
$login = new UserClass();
  
if($login->isLoggedIn() == true){
  include("views/quotes/delete_quote.php");
} else {
  include("views/loginForm.php");
}