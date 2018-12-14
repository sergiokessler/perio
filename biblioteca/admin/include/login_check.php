<?php

// si venimos del login, retornamos
if ( (isset($_POST['u'])) and (isset($_POST['p'])) ) {
    $action = 'login';
    return;
}


if (empty($_SESSION['logged_in'])) {
    $action = 'login';
    return;
}
