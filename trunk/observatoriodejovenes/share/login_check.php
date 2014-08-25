<?php

// si venimos del login, retornamos

if ( (isset($_POST['u']))
     and
     (isset($_POST['p'])) )
{
    $action = 'login';
    return;
}


if ( (!isset($_SESSION['u']))
    or
    (!isset($_SESSION['p'])) )   
{
    $action = 'home';
    return;
}

/*
if ( ($_SESSION['u'] != md5($config['username'])) 
     or
     ($_SESSION['p'] != md5($config['password'])))
{
    $action = 'login';
    return;
}
 */

