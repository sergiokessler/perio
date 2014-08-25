<?php
/*

$Id: config.php,v 1.2 2007/10/10 17:59:13 develop Exp $

*/

define('DEBUG', false);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$config['realm'] = 'Contenidos Perio Web';


$config['auth'][] = array('admin', 'contenido');
$config['user_table'] = 'usuario';
$config['user_name_field'] = 'usuario';
$config['user_passwd_field'] = 'clave';


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = 'localhost';
$config['db']['database'] = 'contenido';
    $config['db']['username'] = 'contenido';
    $config['db']['password'] = 'contenido';

//$config['db']['username'] = $_SERVER['PHP_AUTH_USER'];
//$config['db']['password'] = $_SERVER['PHP_AUTH_PW'];


define('MAX_RECORDS_LIST', 500);



