<?php
if(!isset($_SESSION)) { session_start();} 
/* Start session, this is necessary, it must be the first thing in the PHP document after <?php syntax ! */ 
        
/* Full membership with login and registration
 * PHP script that includes login registration form with proper password salting, login form with validation and


/* Require login.php to call login function */
require("engine/engine.php");
/* Require login.php to call login function */
require 'classes/UserClass.php';

/* Call for login function */
$add_article = new UserClass();

if ($add_article->isLoggedIn() == true) {
    include("views/quotes/add_quote.php");
} else {
    include 'views/loginForm.php';
}

