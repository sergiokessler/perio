<?php

/*

$Id: premio_update.php,v 1.1 2007/10/10 17:15:47 develop Exp $

*/


require_once 'share/data_manage.php';

$params['table'] = 'usuario';
$params['primary_key'] = $params['table'];
$params['op'] = 'update';

// <query> 

$field_meta['type']['update']['id'] = 'hidden';


$form =& sak_record_form($params, $field_meta);

$header = $form->createElement('header', 'MyHeader', 'Editando registro en ' . $params['table'] . ':');
$form->insertElementBefore($header, 'op');
$form->addElement('hidden', 'action', $params['table'] . '_update');
$form->addElement('submit', 'btnSubmit', 'Guardar');




if ( (isset($_REQUEST['btnSubmit']))
     and
     ($_REQUEST['btnSubmit'] == 'Guardar')
     and
     ($form->validate()) )
{                            
    $new_row = cleanup_new_row($_POST['new_row']);

    $db = DB::connect($config['db']);
    if (PEAR::isError($db)) die($db->getMessage());

    $record_id = $params['record_id'];
    $res = $db->autoExecute($params['table'], $new_row, DB_AUTOQUERY_UPDATE, "$params[primary_key] = '$record_id'");
    if (PEAR::isError($res)) die($res->getMessage());
    $msg = "El registro a sido modificado satisfactoriamente.";
                                  
    unset($params_cont);
    $params_cont['msg'] = $msg;
    $params_cont['record_id'] = $params['record_id'];
    $params_cont = params_encode($params_cont);

    $continue = 'action=' . $params['table'] . '_select&params=' . $params_cont;
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


?>
