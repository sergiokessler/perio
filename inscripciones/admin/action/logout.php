<?php

/*

$Id: logout.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
$expireTime = - 60*60*24*100; // 100 days
session_set_cookie_params($expireTime);


// Finally, destroy the session.
session_destroy();


$continue = 'action=login';

?>
