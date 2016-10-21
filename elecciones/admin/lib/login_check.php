<?php

// si venimos del login, retornamos

if ( (isset($_POST['u']))
     and
     (isset($_POST['p'])) )
{
    $action = 'login';
    return;
}


if (!isset($_SESSION['logged_in']) and $action != 'login') {
    $action = 'home';
    return;
}


