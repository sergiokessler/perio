<?php

if (empty($inactivity_timeout)) {
    return;
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > ($inactivity_timeout * 60))) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    session_start();
    $logged_in = false;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp


