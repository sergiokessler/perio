<?php

define('DEBUG', true);
if (DEBUG)
{
    ini_set('display_errors', 'On');
}

$anio = '2016';

$config['realm'] = 'Elecciones FPyCS';


$config['users'] = array('elec');


$config['db']['phptype']  = 'pgsql';
$config['db']['hostspec'] = '127.0.0.1';
$config['db']['database'] = 'elecciones' . $anio;
$config['db']['username'] = 'elec';
$config['db']['password'] = 'osvaldolechero';


$db_host = $config['db']['hostspec'];
$db_dbname = $config['db']['database'];
$db_user = $config['db']['username'];
$db_pass = $config['db']['password'];
$db_dsn = "pgsql:host=$db_host;dbname=$db_dbname"; 

$config['db']['pg_str'] = 'host=' . $db_host . ' dbname=' . $db_dbname . ' user=' . $db_user . ' password=' . $db_pass;


define('MAX_RECORDS_LIST', 500);

