<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

//$path = 'admin/share/pear';
//set_include_path(get_include_path() . PATH_SEPARATOR . $path);

define('DEBUG', false);

if (DEBUG)
{
    ini_set('display_errors', 'On');
    require_once 'PEAR.php';
    PEAR::setErrorHandling(PEAR_ERROR_CALLBACK,'pear_error_msg');
}

function pear_error_msg($error)
{
    die($error->getDebugInfo());
}  
 

$config['realm'] = 'Salud y Medios';


$config['auth'][] = array('saludymedios', 'saludymedios');
$config['auth'][] = array('Administrador S', 'sym senior');
$config['auth'][] = array('Administrador J', 'sym junior');
$config['auth'][] = array('Mercedes Benialgo', 'Benialgo');
$config['auth'][] = array('Natalia Panissidi', 'Panissidi');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'saludymedios';
if (isset($_SESSION['logged_in']))
{
    $config['db']['username'] = 'saludymedios';
    $config['db']['password'] = 'saludymedios';
}

define('MAX_RECORDS_LIST', 500);



?>
