<?php

//$path = 'admin/share/pear';
//set_include_path(get_include_path() . PATH_SEPARATOR . $path);

define('DEBUG', true);

set_include_path('.' . PATH_SEPARATOR . '../share/pear');

$config['realm'] = 'Biblioteca Perio UNLP';
$config['locale'] = 'es_AR';
$config['app_root'] = dirname(__FILE__);


$config['db']['dsn'] = 'pgsql:host=127.0.0.1;dbname=dbbiblioteca;user=biblio;password=cdm00';


$config['auth'][] = array('biblio', 'cdm00');


// tmp
//$_SESSION['u'] = 'prueba';
//$_SESSION['p'] = 'prueba';
//$_SESSION['logged_in'] = true; 



if (isset($_SESSION['logged_in']))
{
} 



define('MAX_RECORDS_LIST', 9999);



if (DEBUG)
{
    ini_set('display_errors', 'On');
}



