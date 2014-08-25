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
$params['action'] = 'cargo_update';
$params['continue'] = 'persona';
// <query> 


$db = DB::connect($config['db']);
if (PEAR::isError($db)) die($db->getMessage());


$form_params = params_encode($params);
$form = new HTML_QuickForm('form', 'post');
$form->addElement('header', 'MyHeader', 'Modificar los datos de un cargo:');
$form->addElement('hidden', 'action', $params['action']);
$form->addElement('hidden', 'params', $form_params);

include 'action/cargo_form.php';

$form->addElement('submit', 'btnSubmit', 'Guardar');



// defaults del form

$edit_sql = 'select * from ' . $params['table'] . ' where ' . $params['primary_key'] . ' = ?';
$edit_sql_data = array($record_id);
$edit_row = $db->getRow($edit_sql, $edit_sql_data, DB_FETCHMODE_ASSOC);
    
foreach($edit_row as $key => $value)
{
    $defaults['new_row['.$key.']'] = stripslashes($value);
}

$form->setDefaults($defaults);




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{
    $rec = $db->getRow("select * from $params[table] where $params[primary_key] = ?", array($record_id), DB_FETCHMODE_ASSOC);

    $new_row = cleanup_new_row($_POST['new_row']);

    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_UPDATE, "$params[primary_key] = $record_id");
    if (PEAR::isError($res)) die($res->getMessage());
    $msg = 'El registro a sido modificado satisfactoriamente.';

    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $rec['doc_nro'];
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


