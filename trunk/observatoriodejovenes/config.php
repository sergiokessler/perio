<?php
/*

$Id: config.php,v 1.1 2006/04/12 15:06:31 sak Exp $

*/

define('DEBUG', false);

 

$config['realm'] = 'Observatorio de Jóvenes, FPyCS, UNLP';


$config['auth'][] = array('sak@perio.unlp.edu.ar', 'odj.2014');
$config['auth'][] = array('prueba', 'prueba');
$config['auth'][] = array('consulta', 'consulta');

// tmp
//$_SESSION['u'] = 'prueba';
//$_SESSION['p'] = 'prueba';
//$_SESSION['logged_in'] = true;


$config['db']['dsn'] = 'sqlite:' . __DIR__ . '/db/observatoriodejovenes.db3';


define('MAX_RECORDS_LIST', 500);



set_include_path('.' . PATH_SEPARATOR . 'share/pear');


if (DEBUG)
{
    ini_set('display_errors', 'On');
}


$normalizeChars = array(
    '?'=>'S', '?'=>'s', '?'=>'Dj','?'=>'Z', '?'=>'z', '?'=>'A', '?'=>'A', '?'=>'A', '?'=>'A', '?'=>'A', 
    '?'=>'A', '?'=>'A', '?'=>'C', '?'=>'E', '?'=>'E', '?'=>'E', '?'=>'E', '?'=>'I', '?'=>'I', '?'=>'I', 
    '?'=>'I', '?'=>'N', '?'=>'O', '?'=>'O', '?'=>'O', '?'=>'O', '?'=>'O', '?'=>'O', '?'=>'U', '?'=>'U', 
    '?'=>'U', '?'=>'U', '?'=>'Y', '?'=>'B', '?'=>'Ss','?'=>'a', '?'=>'a', '?'=>'a', '?'=>'a', '?'=>'a', 
    '?'=>'a', '?'=>'a', '?'=>'c', '?'=>'e', '?'=>'e', '?'=>'e', '?'=>'e', '?'=>'i', '?'=>'i', '?'=>'i', 
    '?'=>'i', '?'=>'o', '?'=>'n', '?'=>'o', '?'=>'o', '?'=>'o', '?'=>'o', '?'=>'o', '?'=>'o', '?'=>'u', 
    '?'=>'u', '?'=>'u', '?'=>'y', '?'=>'y', '?'=>'b', '?'=>'y', '?'=>'f'
);


?>
