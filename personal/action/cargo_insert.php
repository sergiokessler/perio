<?php

/*

$Id: premio_insert.php,v 1.4 2007/10/17 18:01:25 develop Exp $

*/

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
} 


require_once 'DB.php'; 
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';


$params['table'] = 'cargo';
$params['primary_key'] = 'cargo_id';
$params['action'] = 'cargo_insert';
$params['continue'] = 'persona';
// <query> 


$db = DB::connect($config['db']);
if (PEAR::isError($db)) die($db->getMessage());


$form_params = params_encode($params);
$form = new HTML_QuickForm('form', 'post');
$form->addElement('header', 'MyHeader', "Agregar un cargo al Doc Nro $record_id:");
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);

include 'action/cargo_form.php';

$form->addElement('submit', 'btnSubmit', 'Guardar');


// defaults



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{

    $new_row = cleanup_new_row($_POST['new_row']);

    $new_row['doc_nro'] = $record_id;


    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_INSERT);
    if (PEAR::isError($res)) die($res->getDebugInfo());
    $msg = "El registro a sido cargado satisfactoriamente.";

                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $record_id;
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['continue'] . '&params=' . $params_cont;
}
else
{
    // <UI>
    include_once 'header.php';
    if (isset($params['msg']))
        echo $params['msg'];
    echo '<br>';
    $form->display();
    include_once 'footer.php';
}


