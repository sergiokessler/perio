<?php

/*

$Id$

*/

require_once 'DB.php';
require_once 'share/data_manage.php';

$params['table'] = 'tpm';
$params['op'] = 'delete';
$params['primary_key'] = 'id';

// <query> 



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Eliminar registro') )
{                            

    $params_cont['msg'] = sak_record_form_process();

    $params_cont = params_encode($params_cont);
}

$continue = 'action=' . $params['table'] . '&params=' . $params_cont;


?>
