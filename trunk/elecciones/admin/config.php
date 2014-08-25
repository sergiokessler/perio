<?php
/*

$Id: config.php,v 1.2 2007/10/10 17:59:13 develop Exp $

*/

define('DEBUG', false);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$anio = '2013';

$config['realm'] = 'Elecciones FPyCS';


$config['auth'][] = array('elec', 'osvaldolechero');

//$config['user_table'] = 'usuario';
//$config['user_name_field'] = 'usuario';
//$config['user_passwd_field'] = 'clave';


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = '127.0.0.1';
$config['db']['database'] = 'elecciones' . $anio;
$config['db']['username'] = 'elec';
$config['db']['password'] = 'osvaldolechero';

//$config['db']['username'] = $_SERVER['PHP_AUTH_USER'];
//$config['db']['password'] = $_SERVER['PHP_AUTH_PW'];


define('MAX_RECORDS_LIST', 500);

