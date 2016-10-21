<?php

// si venimos del login, retornamos

if ( (isset($_POST['u']))
     and
     (isset($_POST['p'])) )
{
    $action = 'login';
    return;
}


if (!isset($_SESSION['u']) )   
{
    $action = 'home';
    return;
}


