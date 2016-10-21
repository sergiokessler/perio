<?php

/*

$Id: premio_delete.php,v 1.1 2007/10/10 17:15:47 develop Exp $

*/

require_once 'DB.php';
require_once 'share/data_manage.php';

$params['table'] = 'urna';
$params['op'] = 'delete';
$params['primary_key'] = $params['table'] . '_id';

// <query> 



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Eliminar registro') )
{                            

    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) die($db->getMessage());

    $record_id     = $params['record_id'];
    $res = $db->query("delete from $params[table] where $params[primary_key] = ?", array($record_id));
    if (PEAR::isError($res)) die($res->getMessage());

    $params_cont['msg'] = "El registro a sido eliminado satisfactoriamente.";

    $params_cont = params_encode($params_cont);
}

$continue = 'action=' . $params['table'] . '&params=' . $params_cont;


?>
