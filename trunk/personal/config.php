<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

define('DEBUG', false);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$config['realm'] = 'Personal FPyCS';


$config['auth'][] = array('personal', 'personal');
$config['auth'][] = array('exptes', 'operativa');
$config['auth'][] = array('ver', 'ver');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'dbpersonal';
if (isset($_SESSION['logged_in']))
{
    $config['db']['username'] = $_SESSION['u'];
    $config['db']['password'] = $_SESSION['p'];
}

define('MAX_RECORDS_LIST', 500);




