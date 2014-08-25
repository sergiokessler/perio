<?php

/*

$Id: premio_update.php,v 1.1 2007/10/10 17:15:47 develop Exp $

*/

require_once 'DB.php';
require_once 'HTML/QuickForm.php'; 
require_once 'share/data_utils.php';

if (isset($params['record_id'])) {
    $record_id = $params['record_id'];
} else {
    echo 'Debe seleccionar un registro. Presione el boton de Atras';
    exit();
}



$params['table'] = 'nota';
$params['primary_key'] = $params['table'] . '_id';
$params['op'] = 'update';

$params_fa = 
// <query> 

$db = DB::connect($config['db']);
if (PEAR::isError($db)) die($db->getMessage());

unset($params_fa);
$params_fa['record_id'] = $record_id;
$params_fa = params_encode($params_fa);

$form = new HTML_QuickForm('form', 'post');
$form->addElement('header', 'MyHeader', 'Editando registro en ' . $params['table'] . ':');
$form->addElement('hidden', 'action', $params['table'] . '_update');
$form->addElement('hidden', 'params', $params_fa);
include 'action/nota_form.php';



if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{                            
    $new_row = cleanup_new_row($_POST['new_row']);


    $record_id = $params['record_id'];
    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_UPDATE, "$params[primary_key] = $record_id");
    if (PEAR::isError($res)) die($res->getDebugInfo());
    $msg = "El registro a sido modificado satisfactoriamente.";
                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $params['record_id'];
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['table'] . '_select&params=' . $params_cont;
}
else
{
    $edit_sql = "select * from $params[table] where $params[primary_key] = ?";
    $edit_sql_data = array($record_id);
    $edit_row = $db->getRow($edit_sql, $edit_sql_data, DB_FETCHMODE_ASSOC);
    
    foreach($edit_row as $key => $value) {
        $form_defaults['new_row['.$key.']'] = stripslashes($value);
    }
    $form->setDefaults($form_defaults);
    

    // <UI>
    include_once 'header.php';
    if (isset($params['msg']))
        echo $params['msg'];
    echo '<br>';
    $form->display();
    include_once 'footer.php';
}


?>
