<?php

//set_include_path(get_include_path() . PATH_SEPARATOR . $path);

define('DEBUG', true);


$config['realm'] = 'FotoCop';
$config['locale'] = 'es_AR';
$config['app_root'] = dirname(__FILE__);


$config['auth'][] = array('fotocop', '123+rw+123');

$config['db']['dsn'] = 'pgsql:host=localhost;dbname=fotocop;user=fotocop;password=fotocop';
$config['db']['username'] = 'fotocop';
$config['db']['password'] = 'fotocop';



define('MAX_RECORDS_LIST', 500);


set_include_path('.' . PATH_SEPARATOR . 'share/pear');


if (DEBUG)
{
    ini_set('display_errors', 'On');
}


function debug($msg) {
    if (DEBUG) {
        echo '<pre>';
        //echo ${$msg}, ': ';
        var_dump($msg);
        echo '</pre>';
    }
}


