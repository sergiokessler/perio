<?php

/*

$Id$

*/

require_once 'DB.php';
require_once 'share/data_manage.php';

$params['table'] = 'inscripcion';
$params['op'] = 'delete';
$params['primary_key'] = 'id';

$sql_delete = 'delete from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?';
$sql_delete_params = array($params['record_id']);
// <query> 



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Eliminar registro') )
{                            

    $msg = '';

    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) {
        die($db->getMessage());
    }

    // borramos la inscripcion
    // el cupo sube por una regla en el server
    $res = $db->query($sql_delete, $sql_delete_params);
    if (PEAR::isError($res)) {
        die($res->getDebugInfo());
    } else {
        $msg = "El registro a sido eliminado satisfactoriamente.";
    }

    $params_cont['msg'] = sak_record_form_process();

    $params_cont = params_encode($params_cont);
}

$continue = 'action=' . $params['table'] . '&params=' . $params_cont;


?>
