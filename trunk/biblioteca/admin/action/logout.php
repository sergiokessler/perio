<?php

/*

$Id: logout.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-42000, '/');
}

// Finally, destroy the session.
session_destroy();


$continue = '?action=login';

