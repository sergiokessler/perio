<?php


define('DEBUG', true);

$config['realm'] = 'Biblioteca Perio UNLP';
$config['session_name'] = 'BiblioPerioUNLP';
$config['locale'] = 'es_AR';
$config['app_charset'] = 'ISO-8859-1';
$config['app_root'] = dirname(__FILE__);

$config['db']['dsn'] = 'pgsql:host=www.perio.unlp.edu.ar;dbname=dbbiblioteca;user=biblio;password=cdm00';


$config['auth'][] = array('biblio', 'cdm00');




/*
 * end CFG
 * 
 */




date_default_timezone_set('America/Argentina/Buenos_Aires');
ini_set('default_charset', $config['app_charset']);

define('MAX_RECORDS_LIST', 9999);


if (DEBUG) {
    ini_set('display_errors', 'On');
}




