<?php
/*

$Id: config.php,v 1.2 2007/10/10 17:59:13 develop Exp $

*/

define('DEBUG', true);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

set_include_path('.:share/pear');


$config['realm'] = 'Biblioteca FPyCS UNLP';
$config['locale'] = 'es_AR';
$config['app_root'] = dirname(__FILE__);


$config['db']['dsn'] = 'pgsql:host=127.0.0.1;dbname=dbbiblioteca;user=biblio;password=cdm00';
$config['db']['username'] = 'fotocop';
$config['db']['password'] = 'fotocop'; 


define('MAX_RECORDS_LIST', 500);


