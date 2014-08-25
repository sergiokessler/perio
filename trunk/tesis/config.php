<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

define('DEBUG', false);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$config['realm'] = 'Tesis FPyCS';


$config['auth'][] = array('tesis', 'siset');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'tesis';
if (isset($_SESSION['logged_in']))
{
    $config['db']['username'] = $_SESSION['u'];
    $config['db']['password'] = $_SESSION['p'];
}

define('MAX_RECORDS_LIST', 500);





?>
