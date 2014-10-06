<?php

define('DEBUG', true);
if (DEBUG)
{
    ini_set('display_errors', 'On');
//    PEAR::setErrorHandling(PEAR_ERROR_DIE);
}

$anio = '2013';

$config['realm'] = 'Elecciones FPyCS';


$config['users'] = array('elec');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = '127.0.0.1';
$config['db']['database'] = 'elecciones' . $anio;
$config['db']['username'] = 'elec';
$config['db']['password'] = 'osvaldolechero';

$config['db']['dsn'] = $config['db']['phptype'] . ':host=' . $config['db']['hostspec'] . ';dbname=' . $config['db']['database'] . ';user=' . $config['db']['username'] . ';password=' . $config['db']['password']; 


$config['db']['pg_str'] = 'host=' . $config['db']['hostspec'] . ' dbname=' . $config['db']['database'] . ' user=' . $config['db']['username'] . ' password=' . $config['db']['password'];


define('MAX_RECORDS_LIST', 500);

