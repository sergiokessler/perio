<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

define('DEBUG', true);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$config['realm'] = 'Expedientes FPyCS';


$config['auth'][] = array('exptes', 'operativa');
$config['auth'][] = array('ver', 'ver');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'dbexpedientes';
if (isset($_SESSION['logged_in']))
{
    $config['db']['username'] = $_SESSION['u'];
    $config['db']['password'] = $_SESSION['p'];
}

define('MAX_RECORDS_LIST', 500);




