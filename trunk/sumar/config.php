<?php
# vim: set fileencoding=latin1 : 


define('DEBUG', false);

 

$config['realm'] = 'Ministerio de Salud de la Nación';


$config['auth'][] = array('admin', 'sumar 2012');
$config['auth'][] = array('cristian.scarpetta', 'scarpetta0b8');
$config['auth'][] = array('julieta.carreras', 'carreras59e');
$config['auth'][] = array('joaquin.segovia', 'segoviaff6');
$config['auth'][] = array('rodrigo.lopez', 'lopezbfe');
$config['auth'][] = array('diego.albervide', 'albervide43e');
$config['auth'][] = array('soledad.secco', 'secco92j');
$config['auth'][] = array('guillermo.boerr', 'boerr62h');
$config['auth'][] = array('flor.cugat', 'cugat39');
$config['auth'][] = array('eduardo.carreras', 'carreras34r');
$config['auth'][] = array('evangelina.colombo', 'colombo87v');
$config['auth'][] = array('ramiro.fernandez.gener', 'gener90h');

$config['auth'][] = array('consulta', 'consulta');

// tmp
//$_SESSION['u'] = 'prueba';
//$_SESSION['p'] = 'prueba';
//$_SESSION['logged_in'] = true;


$config['db']['dsn'] = 'sqlite:' . __DIR__ . '/db/msal_sumar.db3';


define('MAX_RECORDS_LIST', 500);



set_include_path('.' . PATH_SEPARATOR . 'share/pear');


if (DEBUG)
{
    ini_set('display_errors', 'On');
    require_once 'PEAR.php';
    PEAR::setErrorHandling(PEAR_ERROR_CALLBACK,'pear_error_msg');
}

function pear_error_msg($error)
{
    die($error->getDebugInfo());
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


