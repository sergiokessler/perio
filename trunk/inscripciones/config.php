<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

$config['realm'] = 'ins_operador';
session_name($config['realm']);
session_start();


$path = 'admin/share/pear';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

define('DEBUG', false);

if (DEBUG)
{
    ini_set('display_errors', 'On');
    require_once $path . '/PEAR.php';
    PEAR::setErrorHandling(PEAR_ERROR_CALLBACK,'pear_error_msg');
}

function pear_error_msg($error)
{
    die($error->getDebugInfo());
}  


$config['title'] = 'Inscripciones Perio - UNLP';

$config['auth'][] = array('ins_operador', 'ins_operador');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'inscrip_dev';
if (isset($_SESSION['logged_in']))
{
    $config['db']['username'] = $_SESSION['u'];
    $config['db']['password'] = $_SESSION['p'];
}

//$config['db']['username'] = $_SERVER['PHP_AUTH_USER'];
//$config['db']['password'] = $_SERVER['PHP_AUTH_PW'];


define('MAX_RECORDS_LIST', 500);


?>
