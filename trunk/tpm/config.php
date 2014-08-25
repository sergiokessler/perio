<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

define('DEBUG', false);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$config['realm'] = 'Proyecto Libro TPM';


$config['auth'][] = array('tpm', 'tmp');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'tpm_libro';
if (isset($_SESSION['logged_in']))
{
    $config['db']['username'] = $_SESSION['u'];
    $config['db']['password'] = $_SESSION['p'];
}

//$config['db']['username'] = $_SERVER['PHP_AUTH_USER'];
//$config['db']['password'] = $_SERVER['PHP_AUTH_PW'];


define('MAX_RECORDS_LIST', 500);


?>
