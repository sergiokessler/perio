<?php
/*

$Id: config.php,v 1.2 2007/10/10 17:59:13 develop Exp $

*/

define('DEBUG', true);

$config['realm'] = 'Biblioteca FPyCS UNLP';
$config['locale'] = 'es_AR';
$config['app_charset'] = 'ISO-8859-1';
$config['app_root'] = dirname(__FILE__);

$config['db']['dsn'] = 'pgsql:host=127.0.0.1;dbname=dbbiblioteca;user=biblio;password=cdm00';


ini_set('default_charset', $config['app_charset']);

set_include_path('.:share/pear');

define('MAX_RECORDS_LIST', 500);


if (DEBUG) {
    ini_set('display_errors', 'On');
}
